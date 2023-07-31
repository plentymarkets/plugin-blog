<?php

namespace Blog\Extensions;

use Blog\Controllers\BlogController;
use Plenty\Modules\Plugin\Events\LoadSitemapPattern;
use Plenty\Modules\Plugin\Services\PluginSeoSitemapService;
use Plenty\DataBase\DynamoDB\BlogPost;

class BlogSitemapPattern
{
    /**
     * @param LoadSitemapPattern $sitemapPattern
     */
    public function handle(LoadSitemapPattern $sitemapPattern)
    {
        /** @var PluginSeoSitemapService $seoSitemapService */
        $seoSitemapService = pluginApp(PluginSeoSitemapService::class);

        $dynamoPosts = BlogPost::getAll()->sortByDesc('data.post.publishedAt')->toArray();


        $seoSitemapService->setBlogContent($dynamoPosts);
    }
}
