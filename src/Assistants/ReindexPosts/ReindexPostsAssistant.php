<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 29/01/2019
 * Time: 10:18
 */

namespace Blog\Assistants\ReindexPosts;

use Blog\Services\BlogService;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Modules\Wizard\Services\WizardProvider;

/**
 * Class ReindexPostsAssistant
 * @package Blog\Assistants\ReindexPosts
 */
class ReindexPostsAssistant extends WizardProvider
{

    /**
     * The wizard structure
     *
     * @return array
     */
    protected function structure() {

        return [
            'title' => '3. Reindex posts',
            'key' => 'blog-reindex-posts',
            'translationNamespace' => 'Blog',
            'dataSource' => 'Blog\Assistants\ReindexPosts\DataSource\ReindexPostsDataSource',
            'settingsHandlerClass' => 'Blog\Assistants\ReindexPosts\SettingsHandler\ReindexPostsSettingsHandler',
            'reloadStructure' => true,
            "priority" => 810,
            'shortDescription' => 'This assistant re-indexes all posts',
            'topics' => [
                'omni-channel.blog.blog-debug',
            ],
//            'options' => [],

            'steps' => [
                'step1' => [
                    'title' => 'Debug assistant',
                    'description' => 'This is a debug assistant, do not use it if you do not know what you\'re doing',
                    'sections' => [
                        [
                            'title' => 'Fix posts',
                            'description' => 'Reindex all posts',
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
