<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 24/07/2018
 * Time: 22:53
 */

namespace Blog\Controllers;


use Blog\Services\BlogService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Templates\Twig;

class BlogController extends Controller
{
    use Loggable;

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

        return $this->twig->render('Blog::Category.Blog.Article', $data);
    }

    /**
     * @param $categoryId
     * @param Request $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function listArticlesForPagination($categoryId, Request $request)
    {
        $defaultItemsPerPage = 5;

        $filters = $request->except(['page', 'itemsPerPage', 'plentyMarkets']);
        $page = empty($request->get('page')) ? 1 : $request->get('page');
        $articlesPerPage = empty($request->get('itemsPerPage')) ? $defaultItemsPerPage : $request->get('itemsPerPage');

        $blogPosts = pluginApp(BlogService::class)->listBlogPosts($categoryId, $page, $articlesPerPage, $filters);

        $data = [
            'categoryId' => $categoryId,
            'blog' => [
                'blogPosts' => $blogPosts,
                'filters' => $filters
            ]
        ];

        return $this->twig->render('Blog::Category.Blog.Partials.CategoryBlogList', $data);

    }
}