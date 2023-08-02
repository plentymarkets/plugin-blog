<?php

namespace Blog\Providers;

use Blog\Assistants\BlogLanding\BlogLandingAssistant;
use Blog\Assistants\DuplicatedPosts\DuplicatedPostsAssistant;
use Blog\Assistants\Folders\BlogFolder;
use Blog\Assistants\IncompletePosts\IncompletePostsAssistant;
use Blog\Assistants\IndexCheck\IndexCheckAssistant;
use Blog\Assistants\QuickPreviews\QuickPreviewsAssistant;
use Blog\Assistants\ReindexPosts\ReindexPostsAssistant;
use Blog\AssistantServices\AssistantsService;
use Blog\Contexts\BlogCategoryContext;
use Blog\Contexts\BlogContext;
use Blog\Extensions\BlogSitemapPattern;
use Blog\Services\BlogService;
use Blog\Twig\CategoryTree;
use Blog\Twig\Links;
use Ceres\Helper\LayoutContainer;
use IO\Helper\ResourceContainer;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Http\Request;
use Plenty\Modules\Wizard\Contracts\WizardContainerContract;
use Plenty\Modules\Plugin\Events\LoadSitemapPattern;


/**
 * Class BlogServiceProvider
 * @package Blog\Providers
 */
class BlogServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     * @throws \ErrorException
     */
    public function register()
    {
        $this->getApplication()->register(BlogRouteServiceProvider::class);
        $this->getApplication()->singleton(AssistantsService::class);
    }

    /**
     * Boot a template for the footer that will be displayed in the template plugin instead of the original footer.
     */
    public function boot(Twig $twig, Dispatcher $eventDispatcher, Request $request, ConfigRepository $config)
    {
        pluginApp(WizardContainerContract::class)->register('blog-landing-page', BlogLandingAssistant::class);
        if($config->get('Blog.other.debug') == 'true') {
            pluginApp(WizardContainerContract::class)->registerFolders(BlogFolder::class);

            pluginApp(WizardContainerContract::class)->register('blog-fix-duplicates', DuplicatedPostsAssistant::class);
            pluginApp(WizardContainerContract::class)->register('blog-fix-incomplete-posts', IncompletePostsAssistant::class);
            pluginApp(WizardContainerContract::class)->register('blog-reindex-posts', ReindexPostsAssistant::class);
            pluginApp(WizardContainerContract::class)->register('blog-check-index', IndexCheckAssistant::class);
            pluginApp(WizardContainerContract::class)->register('blog-quick-previews', QuickPreviewsAssistant::class);
        }

        $twig->addExtension(Links::class);
        $twig->addExtension(CategoryTree::class);

        $eventDispatcher->listen(LoadSitemapPattern::class, BlogSitemapPattern::class);

        // Custom components
        $eventDispatcher->listen('IO.Resources.Import',
            function (ResourceContainer $container) {
                $container->addScriptTemplate('Blog::Category.Components.BlogList');
                $container->addScriptTemplate('Blog::Category.Components.BlogUpdateCategoryUrl');
                $container->addScriptTemplate('Blog::Sidebar.Components.Search');
                $container->addScriptTemplate('Blog::Sidebar.Components.LatestPosts');
                $container->addScriptTemplate('Blog::Article.Components.Post');
                $container->addScriptTemplate('Blog::Article.Components.Layouts.Featured1');
                $container->addScriptTemplate('Blog::Article.Components.Layouts.HorizontalMD');
                $container->addScriptTemplate('Blog::Article.Components.Layouts.HorizontalLG');
                $container->addScriptTemplate('Blog::Article.Components.Layouts.VerticalSM');
                $container->addScriptTemplate('Blog::Article.Components.Layouts.VerticalXL');
            }
        );

        // Category Blog page
        // 90 priority, 100 is Ceres, themes typically use "0" because that's how theme creators are instructed in the theme creation guide
        $eventDispatcher->listen('IO.tpl.category.blog', function(TemplateContainer $container, $data) use ($request)
        {
            $blogData = [
                'filters' => $request->except(['plentyMarkets']),
                'updateBlogUrl' => true
            ];

            $container->setTemplate('Blog::Category.CategoryBlog')->withData($blogData, 'blogData');

            return false;
        });

        $eventDispatcher->listen('IO.tpl.blog.category', function(TemplateContainer $container, $data) use ($request)
        {
            $blogData = [
                'filters' => $request->except(['plentyMarkets']),
                'updateBlogUrl' => false
            ];

            $container->setTemplate('Blog::Category.CategoryBlog')->withData($blogData, 'blogData');

            return false;
        }, 90);

        $eventDispatcher->listen('IO.tpl.blog.article', function(TemplateContainer $container, $data)
        {
            $container->setTemplate('Blog::Article.Article')->setTemplateData($data);

            return false;
        }, 90);

        $eventDispatcher->listen('IO.tpl.blog.search', function(TemplateContainer $container, $data)
        {
            $container->setTemplate('Blog::Category.Search')->setTemplateData($data);

            return false;
        }, 90);

        $eventDispatcher->listen('IO.tpl.blog.landing', function(TemplateContainer $container, $data)
        {
            $container->setTemplate('Blog::Landing.Landing')->setTemplateData($data);

            return false;
        }, 90);



        // Context for single article
        $eventDispatcher->listen('IO.ctx.blog.*', function (TemplateContainer $container) {
            $container->setContext(BlogContext::class);
            return false;
        }, 90);

        // Context for Category Blog page
        $eventDispatcher->listen('IO.ctx.blog.category', function (TemplateContainer $container) {
            $container->setContext(BlogCategoryContext::class);
            return false;
        }, 90);

        // Context for Category Blog page
        $eventDispatcher->listen('IO.ctx.category.blog', function (TemplateContainer $container) {
            $container->setContext(BlogCategoryContext::class);
            return false;
        }, 90);



        // Automatic container links
        $eventDispatcher->listen("Ceres.LayoutContainer.Template.Style", function(LayoutContainer $container) use ($twig) {
            $container->addContent($twig->render('Blog::content.Style'));
        });

        $eventDispatcher->listen("Ceres.LayoutContainer.Script.Loader", function(LayoutContainer $container) use ($twig) {
            $container->addContent($twig->render('Blog::content.Scripts'));
        });

        // Config bools are strings
        if($config->get('Blog.general.entrypoint.automaticLink') === 'true') {
            $eventDispatcher->listen("Ceres.LayoutContainer.Header.LeftSide", function(LayoutContainer $container) use ($twig) {
                $service = pluginApp(BlogService::class);
                $data = $service->prepareDataForEntrypoint();
                $container->addContent($twig->render('Blog::content.BlogEntrypoint', $data));
            });
        }
    }
}
