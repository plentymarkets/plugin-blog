<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 11.09.18
 * Time: 12:45
 */

namespace Blog\Services;

use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Plugin\Http\Request;

/**
 * Class BlogService
 * @package Blog\Services
 */
class BlogService
{

    /**
     * Gets a single blog post
     *
     * @param string $url
     * @return mixed
     */
    public function getBlogPost(string $url)
    {
        $filters = [
            'urlName' => $url
        ];
        $blogPosts = pluginApp(BlogPostRepositoryContract::class)->listPosts(1, 1, $filters);

        $blogPost = $blogPosts['entries'][0];

        return $blogPost;
    }

    /**
     * This should go in a helper when we need more helper methods
     *
     * @param Request $request
     * @return array
     */
    public function extractFilters(Request $request)
    {
        return $request->except(['page', 'itemsPerPage', 'plentyMarkets']);
    }
}