<?php

namespace Blog\Providers;

use Blog\Services\BlogService;
use Ceres\Contexts\CategoryContext;
use IO\Helper\ResourceContainer;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Http\Request;


class BlogServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     * @throws \ErrorException
     */
    public function register()
    {
        $this->getApplication()->register(BlogRouteServiceProvider::class);
    }

    /**
     * Boot a template for the footer that will be displayed in the template plugin instead of the original footer.
     */
    public function boot(Twig $twig, Dispatcher $eventDispatcher, Request $request)
    {

        // Custom components
        $eventDispatcher->listen('IO.Resources.Import',
            function (ResourceContainer $container) {
                $container->addScriptTemplate('Blog::Category.Blog.Components.LoadMoreArticles');
            }
        );

        // Category Blog page
        // 90 priority, 100 is Ceres, themes typically use "0" because that's how theme creators are instructed in the theme creation guide
        $eventDispatcher->listen('IO.tpl.category.blog', function(TemplateContainer $container) use ($request)
        {
            $blogPosts = pluginApp(BlogService::class)->listBlogPosts(null, $request->get('page'), $request->get('itemsPerPage'));
            $container->setTemplate('Blog::Category.Blog.CategoryBlog')->withData($blogPosts, 'blogPosts');
            return false;
        }, 90);

        // Context for Category Blog page
        $eventDispatcher->listen('IO.ctx.category.blog', function (TemplateContainer $container) {
            $container->setContext(CategoryContext::class);
            return false;
        }, 90);



    }
}