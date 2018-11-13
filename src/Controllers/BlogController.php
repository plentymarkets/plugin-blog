<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 24/07/2018
 * Time: 22:53
 */

namespace Blog\Controllers;


use Blog\Services\BlogService;
use IO\Services\TagService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Templates\Twig;

class BlogController extends Controller
{

    /**
     * @var Twig
     */
    private $twig;

    /**
     * ItemController constructor.
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @param $urlName
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function showArticle($urlName)
    {

        $blogPost = pluginApp(BlogService::class)->getBlogPost($urlName);

        $data = [
            'urlName' => $urlName,
            'blogPost' => $blogPost
        ];

        if(!empty($blogPost))
        {
            return $this->twig->render('Blog::Category.Blog.Article', $data);
        }else{
            return $this->twig->render('Ceres::StaticPages.PageNotFound');
        }

    }


    /**
     * @param Request $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function searchArticles(Request $request)
    {
        $searchString = $request->get('search', '');

        $data = [
            'filters' => json_encode(['search' => $searchString]),
            'page' => [
                'type' => 'search',
                'title' => 'Search'
            ]
        ];

        return $this->twig->render('Blog::Category.Blog.Search', $data);
    }


    /**
     * @param int $tagId
     * @param Request $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function listArticlesByTag(int $tagId, Request $request)
    {
        $tag = pluginApp(TagService::class)->getTagById($tagId);

        $data = [
            'filters' => json_encode(['tag' => (string)$tagId]),
            'page' => [
                'type' => 'tag',
                'title' => 'Search by tag: ' . $tag['tagName']
            ]
        ];

        return $this->twig->render('Blog::Category.Blog.Search', $data);

    }

}