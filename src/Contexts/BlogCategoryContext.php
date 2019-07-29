<?php

namespace Blog\Contexts;

use Blog\Services\BlogService;
use IO\Helper\ContextInterface;
use IO\Services\CategoryService;
use IO\Services\UrlService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Translation\Translator;

class BlogCategoryContext extends BlogContext implements ContextInterface
{
    public $category = null;
    public $categoryUrl;

    public $metaRobots;

    public function init($params)
    {
        parent::init($params);

        $service = pluginApp(CategoryService::class);
        $urlService = pluginApp(UrlService::class);
        $translator = pluginApp(Translator::class);

        $service->setCurrentCategoryID($params['category']->plenty_category_id);
        $currentCategory = $service->getCurrentCategory();
        $homepageUrl = $urlService->getHomepageURL();

        // Build URL. $service->getURL() adds the language prefix which we do not want
        $hierarchy = $service->getHierarchy($currentCategory->id);
        foreach($hierarchy as $hierarchyCategory) {
            $this->categoryUrl .= '/' . $hierarchyCategory['details'][0]['nameUrl'];
        }

        $this->category = $currentCategory->toArray();
        $this->categoryUrl = $homepageUrl . ($homepageUrl !== '/' ? '/' : '') . $translator->trans('Blog::Landing.urlName') . $this->categoryUrl;

        $this->metaRobots = str_replace('_', ', ', $this->category['details'][0]['metaRobots']);
    }
}