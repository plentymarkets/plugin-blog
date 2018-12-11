<?php

namespace Blog\Contexts;

use Ceres\Contexts\GlobalContext;
use IO\Helper\ContextInterface;
use IO\Services\CategoryService;
use Plenty\Plugin\ConfigRepository;

class BlogContext extends GlobalContext implements ContextInterface
{

    public function init($params)
    {
        parent::init($params);

        $blogCategoryId = pluginApp(ConfigRepository::class)->get('Blog.general.entrypoint.category');

        if(!empty($blogCategoryId))
        {
            $this->categories = pluginApp(CategoryService::class)->getNavigationTree('blog', null, 6);
        }

    }
}