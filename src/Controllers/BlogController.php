<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 24/07/2018
 * Time: 22:53
 */

namespace Blog\Controllers;


use Blog\Services\BlogService;
use Ceres\Contexts\GlobalContext;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use IO\Controllers\LayoutController;
use IO\Services\SessionStorageService;
use IO\Services\TagService;
use IO\Services\WebstoreConfigurationService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Plugin\Application;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Templates\Twig;
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
    public function searchArticles($searchString, Request $request)
    {
        $data = [
            'filters' => ['search' => $searchString],
            'page' => [
                'template' => 'blog',
                'type' => 'search',
                'metaTitle' => 'Search',
                'title' => '' // Search
            ]
        ];

        return $this->renderTemplate('tpl.blog.search', $data);

    }


    /**
     * @param int $tagId
     * @param string $tagName
     * @param Request $request
     * @return string
     * @throws \ErrorException
     */
    public function listArticlesByTag(int $tagId, Request $request, string $tagName = '')
    {
        $tag = pluginApp(TagService::class)->getTagById($tagId);

        $data = [
            'filters' => ['tag' => (string)$tagId],
            'page' => [
                'template' => 'blog',
                'type' => 'tag',
                'metaTitle' => 'Search tag: ' . $tag['tagName'],
                'title' => 'Search by tag: ' . $tag['tagName']
            ]
        ];

        return $this->renderTemplate('tpl.blog.search', $data);

    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function listArticles(Request $request)
    {
        $lang = pluginApp(SessionStorageService::class)->getLang();
        $clientStoreId = pluginApp(Application::class)->getWebstoreId();

        // These filters should not be overwritten by the requested filters
        $defaultFilters = [
            'active' => 'true',
            'publishedAtTo' => date('Y-m-d H:i:s'),
            'lang' => $lang,
            'clientStoreId' => $clientStoreId
        ];

        $page = $request->get('page', 1);
        $articlesPerPage = $request->get('itemsPerPage', 5);

        $filters = pluginApp(BlogService::class)->extractFilters($request);
        $filters = array_merge($filters, $defaultFilters);

        return pluginApp(BlogPostRepositoryContract::class)->listPosts($page, $articlesPerPage, $filters);

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
            ]
        ];

        return $this->renderTemplate('tpl.blog.landing', $data);
    }

    public function test()
    {
//        $service = pluginApp(BlogService::class);
//        dd($service->buildCustomUrlTranslationsByLanguage());
    }

}
