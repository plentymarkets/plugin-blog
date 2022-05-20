<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 24/07/2018
 * Time: 22:53
 */

namespace Blog\Controllers;


use Blog\Services\BlogService;
use IO\Api\ResponseCode;
use IO\Controllers\LayoutController;
use IO\Services\CategoryService;
use IO\Services\SessionStorageService;
use IO\Services\TagService;
use IO\Services\UrlService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Blog\Services\BlogPluginService;
use Plenty\Modules\Category\Contracts\CategoryRepositoryContract;
use Plenty\Modules\Webshop\Helpers\UrlQuery;
use Plenty\Plugin\Application;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Plenty\Plugin\Translation\Translator;

class BlogController extends LayoutController
{

    /**
     * @param $urlName
     * @return string
     * @throws \ErrorException
     */
    public function showArticle($urlName)
    {
        $blogPost = pluginApp(BlogService::class)->getBlogPost($urlName);

        $data = [
            'page' => [
                'template' => 'blog'
            ],
            'urlName' => $urlName,
            'blogPost' => $blogPost
        ];


        if(!empty($blogPost)) {
            return $this->renderTemplate('tpl.blog.article', $data);
        }
        else {
            return $this->renderTemplate('tpl.page-not-found');
        }
    }


    /**
     * @param Request $request
     * @return string
     * @throws \ErrorException
     */
    public function searchArticles($searchString, Request $request, Translator $translator)
    {
        $data = [
            'filters' => ['search' => $searchString],
            'page' => [
                'template' => 'blog',
                'type' => 'search',
                'metaTitle' => $translator->trans('Blog::Template.search'),
                'title' => '' // Search
            ]
        ];

        return $this->renderTemplate('tpl.blog.search', $data);
    }


    /**
     * @param Request $request
     * @param Translator $translator
     * @param int $tagId
     * @param string $tagName
     * @return string
     * @throws \ErrorException
     */
    public function listArticlesByTag(Request $request, Translator $translator, int $tagId, string $tagName = '')
    {
        $tag = pluginApp(TagService::class)->getTagById($tagId);
        $title = $translator->trans('Blog::Template.searchByTag'). ': ' . $tag['tagName'];

        $data = [
            'filters' => ['tag' => (string)$tagId],
            'page' => [
                'template' => 'blog',
                'type' => 'tag',
                'metaTitle' =>  $title,
                'title' => $title
            ]
        ];

        return $this->renderTemplate('tpl.blog.search', $data);

    }


    /**
     * @param Request $request
     * @param BlogService $blogService
     * @param CategoryService $categoryService
     * @param ConfigRepository $config
     * @return mixed
     */
    public function listArticles(Request $request, BlogService $blogService, CategoryService $categoryService, ConfigRepository $config)
    {
        $navigationList = $blogService->getNavigationList();
        $lang = pluginApp(SessionStorageService::class)->getLang();
        $clientStoreId = pluginApp(Application::class)->getWebstoreId();
        $landingUrlName = $blogService->getLandingUrlName();
        $landingUrl = $blogService->buildUrl($landingUrlName);

        // These filters should not be overwritten by the requested filters
        $defaultFilters = [
            'active' => 'true',
            'publishedAtTo' => date('Y-m-d H:i:s'),
            'lang' => $lang,
            'clientStoreId' => $clientStoreId
        ];

        $page = $request->get('page', 1);
        $articlesPerPage = $request->get('itemsPerPage', 5);

        $filters = $blogService->extractFilters($request);
        $filters = array_merge($filters, $defaultFilters);
        $paginatedPosts = pluginApp(BlogPostRepositoryContract::class)->listPosts($page, $articlesPerPage, $filters);

        $posts = $paginatedPosts['entries'];


        foreach($posts as $post) {

            $categoryUrl = $categoryService->getURLById($post['data']['category']['id']);
            $post->category = $navigationList[$post['data']['category']['id']];

            // If we have the category url
            if(!empty($categoryUrl)) {
                // And it's not for the default language we need to remove the language prefix
                if(strpos($categoryUrl,"/$lang/") === 0 ){
                    $categoryUrl = str_replace("/$lang/", '/', $categoryUrl);
                }
                // prefix it with the landing url
                $categoryUrl = $landingUrl . $categoryUrl;
                $categoryUrl = str_replace('//','/', $categoryUrl);
            }else{
                $categoryUrl = $landingUrl;
            }

            // The config stores a string 'false', not a boolean
            if($config->get('Blog.general.list.showAuthor') === 'false') {
                // Can't unset $post->data['user']
                $temporaryData = $post->data;
                unset($temporaryData['user']);
                $post->data = $temporaryData;
            }

            $postUrl = $categoryUrl . '/' . $post['data']['post']['urlName'] . (UrlQuery::shouldAppendTrailingSlash() ? '/' : '');
            $postUrl = str_replace('//','/', $postUrl);

            $post->urls = [
                'postUrl' => $postUrl,
                'landingUrl' => $landingUrl,
                'categoryUrl' => $categoryUrl
            ];
        }

        $paginatedPosts['entries'] = $posts;

        return $paginatedPosts;

    }

    /**
     * @param Request $request
     * @return string
     * @throws \ErrorException
     */
    public function showLandingPage(Request $request, BlogService $blogService)
    {
        $lang = $blogService->getLanguage();
        $translations = $blogService->buildCustomUrlTranslationsByLanguage($lang);

        $data = [
            'blogCustomUrlName' => $translations['urlName'],
            'page' => [
                'template' => 'blog',
                'type' => 'landing',
                'metaTitle' => $translations['landingTitle'],
                'title' => $translations['landingTitle']
            ],
            'blogData' => [
                'filters' => $request->except(['plentyMarkets'])
            ]
        ];

        return $this->renderTemplate('tpl.blog.landing', $data);
    }

    /**
     * @param Request $request
     * @param null $part1
     * @param null $part2
     * @param null $part3
     * @param null $part4
     * @param null $part5
     * @return Response|string
     * @throws \ErrorException
     */
    public function showArticleOrCategory(Request $request, $part1 = null, $part2 = null, $part3 = null, $part4 = null, $part5 = null)
    {
        // TODO DI these
        $blogPluginService = pluginApp(BlogPluginService::class);
        $blogPostRepository = pluginApp(BlogPostRepositoryContract::class);
        $urlService = pluginApp(UrlService::class);
        $translator = pluginApp(Translator::class);

        /** @var SessionStorageService $sessionService */
        $sessionService  = pluginApp(SessionStorageService::class);
        $lang = $sessionService->getLang();
        $webstoreId = pluginApp(Application::class)->getWebstoreId();

        $lastPart = '';
        $landingUrlName = $translator->trans('Blog::Landing.urlName');

        // We can't use dynamic variables
        if($part1) {
            $lastPart = $part1;
            if($part2) {
                $lastPart = $part2;
                if($part3) {
                    $lastPart = $part3;
                    if($part4) {
                        $lastPart = $part4;
                        if($part5) {
                            $lastPart = $part5;
                        }
                    }
                }
            }
        }

        // Ok now that we have the last part let's find out what it is
        // --------
        // Old post - example urlname "b-16"
        // --------
        if(strpos($lastPart,'b-') === 0 ){
            $oldPostId = str_replace('b-', "", $lastPart);

            if(is_numeric($oldPostId)) {
                $oldPost = $blogPostRepository->getOldPostById(intval($oldPostId));
                if($oldPost) {
                    return $urlService->redirectTo("$landingUrlName/$oldPost->newUrlNameSlug");
//                    return $this->showArticle($oldPost->newUrlNameSlug);
                }
            }
        }

        // --------
        // New post
        // --------
        $blogPost = pluginApp(BlogService::class)->getBlogPost($lastPart . UrlQuery::shouldAppendTrailingSlash() ? '/' : '');
        if($blogPost) {
            return $this->showArticle($lastPart . UrlQuery::shouldAppendTrailingSlash() ? '/' : '');
        }

        // --------
        // Category
        // --------
        $category = $blogPluginService->findCategoryByUrl($part1, $part2, $part3, $part4, $part5, null, $webstoreId, $lang);

        // If it's not a valid category : 404
        if ($category === null || (($category->clients->count() == 0 || $category->details->count() == 0) && !$this->app->isAdminPreview()))
        {
            /** @var Response $response */
            $response = pluginApp(Response::class);
            $response->forceStatus(ResponseCode::NOT_FOUND);

            return $response;
        }

        $data = [
            'category' => $category
        ];
        return $this->renderTemplate('tpl.blog.category', $data);
    }

}
