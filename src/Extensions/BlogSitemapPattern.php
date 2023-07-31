<?php

namespace Blog\Extensions;

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
        /** @var PluginSeoSitemapService $seoSitemapService */
        $seoSitemapService = pluginApp(PluginSeoSitemapService::class);

        $assistantsService = pluginApp(AssistantsService::class);
        $dynamoPosts = $assistantsService->getDynamoDbPosts();

        $seoSitemapService->setBlogContent($dynamoPosts);
    }
}
