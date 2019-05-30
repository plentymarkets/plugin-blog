<?php

namespace Blog\Containers;

use Blog\Services\BlogService;
use Plenty\Plugin\Templates\Twig;

class BlogEntrypoint
{
    /**
     * @param Twig $twig
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function call(Twig $twig, BlogService $service, $page)
    {
        $data = $service->prepareDataForEntrypoint();
        return $twig->render('Blog::content.BlogEntrypoint', $data);
    }
}