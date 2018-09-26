<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 11.09.18
 * Time: 12:45
 */

namespace Blog\Services;

use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;

/**
 * Class BlogService
 * @package Blog\Services
 */
class BlogService
{

    /**
     * @return mixed
     */
    public function listBlogPosts($categoryId, $page, $articlesPerPage)
    {
        $defaultArticlesPerPage = 5;

        $page = empty($page) ? 1 : $page;
        $articlesPerPage = empty($articlesPerPage) ? $defaultArticlesPerPage : $articlesPerPage;

        // TODO handle some filters here, when the time comes
        $blogPosts = pluginApp(BlogPostRepositoryContract::class)->listPosts($page,$articlesPerPage);
        return $blogPosts;
    }

    /**
     * @param $postId
     * @return mixed
     */
    public function getBlogPost($postId)
    {
        $blogPost = pluginApp(BlogPostRepositoryContract::class)->getPost($postId);
        return $blogPost;
    }
}