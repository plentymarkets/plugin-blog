<?php

namespace Blog\Containers;

use Plenty\Plugin\Templates\Twig;

class Styles
{
    /**
     * @param Twig $twig
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function call(Twig $twig):string
    {
        return $twig->render('Blog::content.Style');
    }
}