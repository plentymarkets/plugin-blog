<?php

namespace Blog\Containers;

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
    public function call(Twig $twig, $page)
    {
        return $twig->render('Blog::content.BlogEntrypoint');
    }
}