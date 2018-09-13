<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 11.09.18
 * Time: 12:45
 */

namespace Blog\Services;

use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Blog\Repositories\BlogPostRepository;

/**
 * Class BlogService
 * @package Blog\Services
 */
class BlogService
{

    /**
     * @return mixed
     */
    public function listBlogPosts()
    {
        // TODO handle some filters here, when the time comes
        $blogPosts = pluginApp(BlogPostRepositoryContract::class)->listPosts();
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