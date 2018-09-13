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

    private $twig;

    /**
     * ItemController constructor.
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function showArticle($postId)
    {
        $blogPost = pluginApp(BlogService::class)->getBlogPost($postId);

        $data = [
            'postId' => $postId,
            'blogPost' => $blogPost
        ];

        return $this->twig->render('Blog::Category.Blog.Article', $data);
    }



}