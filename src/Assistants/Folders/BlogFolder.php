<?php

namespace Blog\Assistants\Folders;

use Plenty\Modules\Wizard\Services\WizardFolderProvider;

/**
 * Class BlogFolder
 * @package Plenty\Modules\Blog\Wizards\Folders
 */
class BlogFolder extends WizardFolderProvider
{

    /**
     * Folders
     *
     * @return array
     */
    protected function folders() {
        return [
            'blog-debug' => [
                'name' => 'Debug',
                'shortDescription' => 'Detect and fix issues in your blog posts',
                'priority' => 200,
                'parent' => 'blog'
            ]
        ];
    }

}
