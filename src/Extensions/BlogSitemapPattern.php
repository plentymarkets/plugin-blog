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
        dd($dynamoPosts);

        $seoSitemapService->setBlogContent([
                [
                    'publish_date' => '2023-01-25',
                    'url' => 'https://kn71h80kvr3b.c14-01.plentymarkets.com/blog/blog-news/mein-erster-beitrag/',
                    'title' => 'Mein erster Beitrag',
                    'lang' => 'de',
                    'keywords' => 'News,Rabatt'
                ],
                [
                    'publish_date' => '2023-01-26',
                    'url' => 'https://kn71h80kvr3b.c14-01.plentymarkets.com/blog/blog-news/mein-erster-beitrag/',
                    'title' => 'Mein zweiter Beitrag',
                    'lang' => 'de',
                    'keywords' => 'News'
                ]
            ]);
    }
}
