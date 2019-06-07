<?php

namespace Blog\Contexts;

use Ceres\Contexts\GlobalContext;
use IO\Helper\ContextInterface;
use IO\Services\CategoryService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Translation\Translator;

class BlogContext extends GlobalContext implements ContextInterface
{

    public function init($params)
    {
        parent::init($params);

        $landingUrl = pluginApp(Translator::class)->trans('Blog::Landing.urlName');

        $this->categories = pluginApp(CategoryService::class)->getNavigationTree('blog', null, 6);

        $this->updateCategoryTree($this->categories, $landingUrl);

    }

    /**
     * Update category urls ( and maybe more than that in the future )
     *
     * @param $categories
     * @param $landingUrl
     */
    private function updateCategoryTree(&$categories, $landingUrl)
    {
        foreach($categories as &$category) {
            if(!empty($category['details'])) {
                $category['details'][0]['nameUrl'] = "$landingUrl/" . $category['details'][0]['nameUrl'];
            }
        }
    }
}