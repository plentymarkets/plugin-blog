<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 11.09.18
 * Time: 12:45
 */

namespace Blog\Services;

use IO\Services\SessionStorageService;
use IO\Services\UrlBuilder\UrlQuery;
use IO\Services\WebstoreConfigurationService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Blog\Services\BlogPluginService;
use Plenty\Modules\PluginMultilingualism\Contracts\PluginTranslationRepositoryContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Translation\Translator;

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

    /**
     * @return array
     */
    public function getLanguages()
    {
        return [
            'de',
            'en',
            'fr',
            'it',
            'es',
            'tr',
            'nl',
            'pl',
            'nn',
            'da',
            'se',
            'cz',
            'ru',
            'sk',
            'cn',
            'vn',
            'pt',
            'bg',
            'ro'
        ];
    }

    public function getCustomTranslations(string $lang = '')
    {
        $pluginTranslationRepositoryContract = pluginApp(PluginTranslationRepositoryContract::class);

        $filters = [
            'pluginSetId' => $this->getPluginSetId(),
            'pluginName' => 'Blog'
        ];

        $allTranslations = $pluginTranslationRepositoryContract->listTranslations($filters);

        $translationsByLanguage = [];

        foreach($allTranslations as $translation) {
            if($translation['fileName'] == 'Landing.properties' && $translation['key'] == 'urlName') {
                $translationsByLanguage[$translation['languageCode']][$translation['key']] = $translation['value'];
            }
        }

        if(!empty($lang) && in_array($lang,$this->getLanguages())) {
            return $translationsByLanguage[$lang];
        }

        return $translationsByLanguage;

    }
    
    /**
     * @return mixed
     */
    public function buildCustomUrlTranslationsByLanguage(string $language = '')
    {
        $translationsByLanguage = [
            'default' => [
                'urlName' => 'blog'
            ]
        ];

        $allTranslations = $this->getCustomTranslations();

        foreach($allTranslations as $lang => $translations) {
            foreach($translations as $key => $translation) {
                $translationsByLanguage[$lang] = $translationsByLanguage['default'];
                $translationsByLanguage[$lang][$key] = $translation;
            }
        }

        if(!empty($language) && in_array($language,$this->getLanguages())) {
            return $translationsByLanguage[$language];
        }

        return $translationsByLanguage;
    }

    /**
     * @return int
     */
    public function getPluginSetId()
    {
        $blogPluginService = pluginApp(BlogPluginService::class);
        return $blogPluginService->getPluginSetIdFromConfig();
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        $config = pluginApp(ConfigRepository::class);
        return $config->get('locale');
    }

    /**
     * @return mixed
     */
    public function getDefaultLanguage()
    {
        return pluginApp(WebstoreConfigurationService::class)->getDefaultLanguage();
    }

    /**
     * @return array
     */
    public function prepareDataForEntrypoint()
    {
        $trans = pluginApp(Translator::class);

        $data = [
            'landing' => [
                'url' => $this->buildUrl($trans->trans('Blog::Landing.urlName'))
            ]
        ];

        return $data;
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function buildUrl(string $url = '/')
    {
        return pluginApp(UrlQuery::class,
            ['path' => $url])->toRelativeUrl($this->getDefaultLanguage() !== $this->getLanguage());
    }

    /**
     * @return mixed
     */
    public function getLandingUrlName()
    {
        return pluginApp(Translator::class)->trans('Blog::Landing.urlName');
    }
}
