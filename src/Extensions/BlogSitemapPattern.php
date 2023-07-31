<?php

namespace Blog\Extensions;

use Blog\Services\BlogService;
use Plenty\Modules\Plugin\Events\LoadSitemapPattern;
use Plenty\Modules\Plugin\Services\PluginSeoSitemapService;
use Blog\AssistantServices\AssistantsService;


class BlogSitemapPattern
{
    /**
     * @param LoadSitemapPattern $sitemapPattern
     */
    public function handle(LoadSitemapPattern $sitemapPattern)
    {
        $service = pluginApp(BlogService::class);

        /** @var PluginSeoSitemapService $seoSitemapService */
        $seoSitemapService = pluginApp(PluginSeoSitemapService::class);

        $assistantsService = pluginApp(AssistantsService::class);
        $dynamoPosts = $assistantsService->getDynamoDbPosts();
        $result = [];
        foreach($dynamoPosts as $post) {
            $url = $service->buildFullPostUrl($post);

            $result[] = [
                'publish_date' => date('Y-m-d', strtotime($post['data']['post']['publishedAt'])),
                'url' => $url['postUrl'],
                'title' => $post['data']['post']['title'],
                'lang' => $post['data']['post']['lang'],
                'keywords' => $post['data']['keywords'],
            ];
        }

        $seoSitemapService->setBlogContent($dynamoPosts);
    }
}
