<?php
namespace Blog\Twig;

use Blog\Services\BlogService;
use IO\Services\CategoryService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Webshop\Helpers\UrlQuery;
use Plenty\Plugin\Templates\Extensions\Twig_Extension;
use Plenty\Plugin\Templates\Factories\TwigFactory;
use Plenty\Plugin\Templates\Twig;

class Links extends Twig_Extension
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
        return "Blog_Extension_Links";
    }

    /**
     * @return array the list of functions to add.
     */
    public function getFunctions(): array
    {
        return [
            $this->factory->createSimpleFunction('Link', [$this, 'linkCategory'], ['is_safe' => array('html')]),
            $this->factory->createSimpleFunction('Link_Blog', [$this, 'linkBlog'], ['is_safe' => array('html')]),
            $this->factory->createSimpleFunction('Link_Item', [$this, 'linkItem'], ['is_safe' => array('html')]),
            $this->factory->createSimpleFunction('BuildBody', [$this, 'buildBody'], ['is_safe' => array('html')])
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function linkCategory($id) {
        // URL service -> getCategoryURL doesn't work
        $categoryService = pluginApp(CategoryService::class);
        $blogService = pluginApp(BlogService::class);
        $hierarchy = $categoryService->getHierarchy($id);
        $link = '';

        if($hierarchy[0]['type'] == 'blog') {
            $link .= $blogService->buildLandingUrl();
        }else{
            $link = $blogService->buildUrl();
        }

        // If default language is the same with displayed language
        if($link === '/') $link = '';

        foreach($hierarchy as $key => $category) {
            $link .= '/'.$category['details'][0]['nameUrl'] . (UrlQuery::shouldAppendTrailingSlash() ? '/' : '');
        }

        return $link;
    }

    /**
     * @param $id
     * @return string
     */
    public function linkBlog($id) {
        $postSlug = pluginApp(BlogPostRepositoryContract::class)->getOldPostById(intval($id))->newUrlNameSlug;
        return pluginApp(BlogService::class)->buildPostUrl($postSlug);
    }

    /**
     * @param $id
     * @return string
     */
    public function linkItem($id) {
        return pluginApp(BlogService::class)->buildUrl("a-$id");
    }

    /**
     * @param $body
     * @return mixed
     */
    public function buildBody($body)
    {
        $twig = pluginApp(Twig::class);
        $body = str_replace("{%", "{{", $body);
        $body = str_replace("%}", "}}", $body);
        return $twig->renderString($body,[]);
    }


}