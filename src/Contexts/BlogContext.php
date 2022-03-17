<?php

namespace Blog\Contexts;

use Ceres\Contexts\GlobalContext;
use IO\Helper\ContextInterface;
use IO\Services\CategoryService;
use Plenty\Modules\ContentCache\CacheBlocks\Contracts\CacheTagRepositoryContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Translation\Translator;

class BlogContext extends GlobalContext implements ContextInterface
{

    public $blogCategories;

    public function init($params)
    {
        parent::init($params);

        $config = pluginApp(ConfigRepository::class);
        $landingUrl = pluginApp(Translator::class)->trans('Blog::Landing.urlName');
    
        /** @var CacheTagRepositoryContract $cacheTagRepository */
        $cacheTagRepository = pluginApp(CacheTagRepositoryContract::class);
    
        $this->blogCategories = $cacheTagRepository->makeTaggable(
            'categories',
            function() {
                return pluginApp(CategoryService::class)->getNavigationTree('blog', null, 6);
            }
        );

        $this->prefixBlogCategories($this->blogCategories, $landingUrl);

        // If we only display categories of type blog in the header
        if($config->get('Blog.general.header.categories') === 'blog') {
            $this->categories = $this->blogCategories;
        }else{
            $this->prefixBlogCategories($this->categories, $landingUrl);
        }


    }

    /**
     * Prefix blog categories url ( and maybe more than that in the future )
     *
     * @param $categories
     * @param $landingUrl
     */
    private function prefixBlogCategories(&$categories, $landingUrl)
    {
        foreach($categories as &$category) {
            if($category['type'] != 'blog') continue;

            if(!empty($category['details'])) {
                $category['details'][0]['nameUrl'] = "$landingUrl/" . $category['details'][0]['nameUrl'];
            }
        }
    }
}