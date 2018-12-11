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

        $this->category = pluginApp(CategoryService::class)->getCurrentCategory()->toArray();

        $this->metaRobots = str_replace('_', ', ', $this->category->details[0]->metaRobots);
    }
}