<?php

namespace Blog\Extensions;

use Blog\Services\BlogService;
use Plenty\Modules\Plugin\Events\LoadSitemapPattern;
use Plenty\Modules\Plugin\Services\PluginSeoSitemapService;
use Blog\AssistantServices\AssistantsService;
use Plenty\Modules\Webshop\Contracts\WebstoreConfigurationRepositoryContract;
use Plenty\Plugin\Application;


class BlogSitemapPattern
{
    /**
     * @param LoadSitemapPattern $sitemapPattern
     */
    public function handle(LoadSitemapPattern $sitemapPattern)
    {
        /** @var BlogService $blogService */
        $blogService = pluginApp(BlogService::class);

        /** @var PluginSeoSitemapService $seoSitemapService */
        $seoSitemapService = pluginApp(PluginSeoSitemapService::class);

        /** @var WebstoreConfigurationRepositoryContract $webstoreConfigurationRepository */
        $webstoreConfigurationRepository = pluginApp(WebstoreConfigurationRepositoryContract::class);
        $domain = $webstoreConfigurationRepository->getWebstoreConfiguration()->domainSsl;

        $clientStoreId = pluginApp(Application::class)->getWebstoreId();

        /** @var AssistantsService $assistantsService */
        $assistantsService = pluginApp(AssistantsService::class);
        $dynamoPosts = $assistantsService->getDynamoDbPosts();
        $result = [];
        $now = time();
        foreach($dynamoPosts as $post) {
            if ($post['data']['post']['active'] === "true" 
                && !is_null($post['data']['post']['publishedAtHour'])
                && strtotime($post['data']['post']['publishedAt']) <= $now
                && $clientStoreId === $post['data']['clientStore']['id']
            ) {
                $url = $blogService->buildFullPostUrl($post);
                $result[] = [
                    'publish_date' => date('Y-m-d', strtotime($post['data']['post']['publishedAt'])),
                    'url' => $domain . $url['postUrl'],
                    'title' => $post['data']['post']['title'],
                    'lang' => $post['data']['post']['lang'],
                    'keywords' => $post['data']['metaData']['keywords'],
                ];
            }

        }
        $seoSitemapService->setBlogContent($dynamoPosts);
    }
}
