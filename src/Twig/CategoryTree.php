<?php
namespace Blog\Twig;

use Blog\Services\BlogService;
use IO\Services\CategoryService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Plugin\Templates\Extensions\Twig_Extension;
use Plenty\Plugin\Templates\Factories\TwigFactory;
use Plenty\Plugin\Templates\Twig;

class CategoryTree extends Twig_Extension
{
    /**
     * @var TwigFactory
     */
    private $factory;

    /**
     * BlogTwigExtension constructor.
     * @param TwigFactory $factory
     */
    public function __construct(TwigFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Blog_Extension_Category_Tree";
    }

    /**
     * @return array the list of functions to add.
     */
    public function getFunctions(): array
    {
        return [
            $this->factory->createSimpleFunction('BlogCategoryTree', [$this, 'buildBlogCategoryTree'])
        ];
    }

    /**
     * @param $categories
     * @return string
     */
    public function buildBlogCategoryTree($categories) {
       return $categories;
    }


}