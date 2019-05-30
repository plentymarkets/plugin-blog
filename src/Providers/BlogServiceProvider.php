<?php

namespace Blog\Providers;

use Blog\Assistants\BlogCustomUrl\BlogCustomUrlAssistant;
use Blog\Contexts\BlogCategoryContext;
use Blog\Contexts\BlogContext;
use Blog\Services\BlogService;
use Ceres\Contexts\CategoryContext;
use Ceres\Helper\LayoutContainer;
use IO\Helper\ResourceContainer;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Http\Request;
use Plenty\Modules\Wizard\Contracts\WizardContainerContract;
use Blog\Wizards\BlogWizard;



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
        pluginApp(WizardContainerContract::class)->register('blog-landing-page', BlogCustomUrlAssistant::class);

        // Custom components
        $eventDispatcher->listen('IO.Resources.Import',
            function (ResourceContainer $container) {
                $container->addScriptTemplate('Blog::Category.Blog.Components.BlogList');
                $container->addScriptTemplate('Blog::Category.Blog.Components.Search');
                $container->addScriptTemplate('Blog::Category.Blog.Components.LatestPosts');
            }
        );



        // Category Blog page
        // 90 priority, 100 is Ceres, themes typically use "0" because that's how theme creators are instructed in the theme creation guide
        $eventDispatcher->listen('IO.tpl.category.blog', function(TemplateContainer $container) use ($request)
        {
            $blogData = [
                'filters' => $request->except(['plentyMarkets'])
            ];

            $container->setTemplate('Blog::Category.Blog.CategoryBlog')->withData($blogData, 'blogData');

            return false;
        }, 90);



        $eventDispatcher->listen('IO.tpl.blog.article', function(TemplateContainer $container, $data)
        {
            $container->setTemplate('Blog::Category.Blog.Article')->setTemplateData($data);

            return false;
        }, 90);

        $eventDispatcher->listen('IO.tpl.blog.search', function(TemplateContainer $container, $data)
        {
            $container->setTemplate('Blog::Category.Blog.Search')->setTemplateData($data);

            return false;
        }, 90);

        $eventDispatcher->listen('IO.tpl.blog.landing', function(TemplateContainer $container, $data)
        {
            $container->setTemplate('Blog::Landing.Landing')->setTemplateData($data);

            return false;
        }, 90);



        // Context for Category Blog page
        $eventDispatcher->listen('IO.ctx.category.blog', function (TemplateContainer $container) {
            $container->setContext(BlogCategoryContext::class);
            return false;
        }, 90);

        // Context for single article
        $eventDispatcher->listen('IO.ctx.blog.*', function (TemplateContainer $container) {
            $container->setContext(BlogContext::class);
            return false;
        }, 90);



        // Automatic container links
        $eventDispatcher->listen("Ceres.LayoutContainer.Template.Style", function(LayoutContainer $container) use ($twig) {
            $container->addContent($twig->render('Blog::content.Style'));
        });

        $eventDispatcher->listen("Ceres.LayoutContainer.Script.Loader", function(LayoutContainer $container) use ($twig) {
            $container->addContent($twig->render('Blog::content.Scripts'));
        });

        $eventDispatcher->listen("Ceres.LayoutContainer.Header.LeftSide", function(LayoutContainer $container) use ($twig) {
            $service = pluginApp(BlogService::class);
            $data = $service->prepareDataForEntrypoint();
            $container->addContent($twig->render('Blog::content.BlogEntrypoint', $data));
        });

    }
}