<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 13/09/2018
 * Time: 11:42
 */

namespace Blog\Providers;

use Blog\Services\BlogService;
use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router;

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

        foreach($translations as $lang => $translation) {
            $urlName = $translation['urlName'];

            // Landing
            $router->get("$urlName", 'Blog\Controllers\BlogController@showLandingPage');

            // Search
            $router->get("$urlName/search/{searchString}", 'Blog\Controllers\BlogController@searchArticles');
            $router->get("$urlName/tag/{tagId}/{tagName?}", 'Blog\Controllers\BlogController@listArticlesByTag')->where('tagId', '\d+');

            // Article or category
            $router->get("$urlName/{part1?}/{part2?}/{part3?}/{part4?}/{part5?}", 'Blog\Controllers\BlogController@showArticleOrCategory');
        }

        $apiRouter->version(['v1'], ['namespace' => 'Blog\Controllers'], function ($apiRouter)
        {
            $apiRouter->get('blogplugin/articles', 'BlogController@listArticles');
        });

    }
}