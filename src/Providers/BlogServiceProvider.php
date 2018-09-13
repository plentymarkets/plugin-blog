<?php

namespace Blog\Providers;

use Blog\Services\BlogService;
use Ceres\Contexts\CategoryContext;
use IO\Helper\ResourceContainer;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;

class BlogServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->getApplication()->register(BlogRouteServiceProvider::class);
    }

    /**
     * Boot a template for the footer that will be displayed in the template plugin instead of the original footer.
     */
    public function boot(Twig $twig, Dispatcher $eventDispatcher)
    {

        // Custom components
        $eventDispatcher->listen('IO.Resources.Import',
            function (ResourceContainer $container) {
                $container->addScriptTemplate('Blog::Category.Blog.Components.BlogPosts');
            }
        );

        // Category ITEM page
        // 90 priority, 100 is Ceres, themes typically use "0" because that's how theme creators are instructed in the theme creation guide
        $eventDispatcher->listen('IO.tpl.category.blog', function(TemplateContainer $container)
        {
            $blogPosts = pluginApp(BlogService::class)->listBlogPosts();
            $container->setTemplate('Blog::Category.Blog.CategoryBlog')->withData($blogPosts, 'blogPosts');
            return false;
        }, 90);

    }
}