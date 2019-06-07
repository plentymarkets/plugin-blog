<?php

namespace Blog\Contexts;

use Ceres\Contexts\GlobalContext;
use IO\Helper\ContextInterface;
use IO\Services\CategoryService;
use Plenty\Plugin\ConfigRepository;

class BlogCategoryContext extends BlogContext implements ContextInterface
{
    public $category = null;

    public $metaRobots;

    public function init($params)
    {
        parent::init($params);
        $service = pluginApp(CategoryService::class);

        $service->setCurrentCategoryID($params['category']->plenty_category_id);

        $this->category = $service->getCurrentCategory()->toArray();

        $this->metaRobots = str_replace('_', ', ', $this->category['details'][0]['metaRobots']);
    }
}