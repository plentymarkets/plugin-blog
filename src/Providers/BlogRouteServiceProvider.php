<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 13/09/2018
 * Time: 11:42
 */

namespace Blog\Providers;

use Plenty\Plugin\RouteServiceProvider;
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
    public function map(Router $router)
    {
        $router->get('blog/article/{postId}', 'Blog\Controllers\BlogController@showArticle')->where('postId', '\w+\-\w+\-\w+\-\w+\-\w+');
        $router->get('blog/articles/{categoryId}', 'Blog\Controllers\BlogController@listArticles');
    }
}