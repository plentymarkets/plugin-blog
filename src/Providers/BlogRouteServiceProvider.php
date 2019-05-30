<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 13/09/2018
 * Time: 11:42
 */

namespace Blog\Providers;

use Blog\Services\BlogService;
use Plenty\Modules\PluginMultilingualism\Contracts\PluginTranslationRepositoryContract;
use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router;
use Plenty\Plugin\Translation\Translator;

/**
 * Class BlogRouteServiceProvider
 * @package Blog\Providers
 */
class BlogRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     * @param ApiRouter $apiRouter
     * @throws \Plenty\Plugin\Routing\Exceptions\RouteReservedException
     */
    public function map(Router $router, ApiRouter $apiRouter, BlogService $blogService )
    {
        // We can't know which language is selected at this point... so we register all routes for all languages
        $translations = $blogService->buildCustomUrlTranslationsByLanguage();

        $router->get("test/123", 'Blog\Controllers\BlogController@test');

        foreach($translations as $lang => $translation) {
            $urlName = $translation['urlName'];

            $router->get("$urlName", 'Blog\Controllers\BlogController@showLandingPage');
            $router->get("$urlName/search/{searchString}", 'Blog\Controllers\BlogController@searchArticles');
            $router->get("$urlName/tag/{tagId}/{tagName?}", 'Blog\Controllers\BlogController@listArticlesByTag')->where('tagId', '\d+');
            // TODO Remove the /article/ route when changes are made to the terra preview button
            $router->get("$urlName/article/{urlName}", 'Blog\Controllers\BlogController@showArticle');
            $router->get("$urlName/{urlName}", 'Blog\Controllers\BlogController@showArticle');
        }

        $apiRouter->version(['v1'], ['namespace' => 'Blog\Controllers'], function ($apiRouter)
        {
            $apiRouter->get('blogplugin/articles', 'BlogController@listArticles');
        });

    }
}