<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 13/09/2018
 * Time: 11:42
 */

namespace Blog\Providers;

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
     * @throws \Plenty\Plugin\Routing\Exceptions\RouteReservedException
     */
    public function map(Router $router, ApiRouter $apiRouter)
    {
        $router->get('blog/article/{urlName}', 'Blog\Controllers\BlogController@showArticle');
        $router->get('blog/search/{searchString}', 'Blog\Controllers\BlogController@searchArticles');
        $router->get('blog/tag/{tagId}/{tagName?}', 'Blog\Controllers\BlogController@listArticlesByTag')->where('tagId', '\d+');


        $apiRouter->version(['v1'], ['namespace' => 'Blog\Controllers'], function ($apiRouter)
        {
            $apiRouter->get('blogplugin/articles', 'BlogController@listArticles');
        });

    }
}