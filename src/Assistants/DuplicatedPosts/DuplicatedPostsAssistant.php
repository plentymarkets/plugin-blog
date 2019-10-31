<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 29/01/2019
 * Time: 10:18
 */

namespace Blog\Assistants\DuplicatedPosts;

use Blog\Services\BlogService;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Modules\Wizard\Services\WizardProvider;

/**
 * Class DuplicatedPosts
 * @package Blog\Assistants\DuplicatedPosts
 */
class DuplicatedPostsAssistant extends WizardProvider
{

    /**
     * The wizard structure
     *
     * @return array
     */
    protected function structure() {

        return [
            'title' => 'Duplicated Posts',
            'key' => 'blog-fix-duplicates',
            'translationNamespace' => 'Blog',
            'dataSource' => 'Blog\Assistants\DuplicatedPosts\DataSource\DuplicatedPostsDataSource',
            'settingsHandlerClass' => 'Blog\Assistants\DuplicatedPosts\SettingsHandler\DuplicatedPostsSettingsHandler',
            'reloadStructure' => true,
            'shortDescription' => 'This assistant fixes duplicated blog posts.',
            'topics' => [
                'omni-channel.blog.blog-debug',
            ],
            'options' => [
                'data' => [
                    'count',
                    'urlName'
                ]
            ],

            'steps' => [
                'step1' => [
                    'title' => 'Debug assistant',
                    'description' => 'This is a debug assistant, do not use it if you do not know what you\'re doing',
                    'sections' => [
                        [
                            'title' => 'Fix posts',
                            'description' => 'Fix duplicated posts',
                            'form' => [
                                'agreement' => [
                                    'type' => 'checkbox',
                                    'options' => [
                                        'required' => true,
                                        'name' => 'I know what I\'m doing',
                                    ]
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }
}
