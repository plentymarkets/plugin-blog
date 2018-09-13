<?php

namespace Blog\Containers;

use Plenty\Plugin\Templates\Twig;

class Scripts
{
    /**
     * @param Twig $twig
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function call(Twig $twig)
    {
        return $twig->render('Blog::content.Scripts');
    }
}