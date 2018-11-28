<?php

namespace Blog\Contexts;

use Ceres\Contexts\GlobalContext;
use IO\Helper\ContextInterface;
use IO\Services\CategoryService;
use Plenty\Plugin\ConfigRepository;

class BlogContext extends GlobalContext implements ContextInterface
{
    /**
     * @var array
     */
    public $categories = [];

    public function init($params)
    {
        parent::init($params);

        $blogCategoryId = pluginApp(ConfigRepository::class)->get('Blog.general.entrypoint.category');

        if(!empty($blogCategoryId))
        {
            $blogCategories = pluginApp(CategoryService::class)->getNavigationTree('blog', null, 6);

            $this->categories = [];
            foreach($blogCategories as $blogCategory) {
                if($blogCategory['id'] == $blogCategoryId)
                {
                    $this->categories = $blogCategory['children'];
                    break;
                }
            }
        }

    }
}