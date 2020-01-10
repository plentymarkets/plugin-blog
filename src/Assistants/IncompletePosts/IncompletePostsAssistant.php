<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 29/01/2019
 * Time: 10:18
 */

namespace Blog\Assistants\IncompletePosts;

use Plenty\Modules\Wizard\Services\WizardProvider;

/**
 * Class IncompletePosts
 * @package Blog\Assistants\IncompletePosts
 */
class IncompletePostsAssistant extends WizardProvider
{

    /**
     * The wizard structure
     *
     * @return array
     */
    protected function structure() {

        return [
            'title' => '2. Incomplete Posts',
            'key' => 'blog-fix-incomplete-posts',
            'translationNamespace' => 'Blog',
            'dataSource' => 'Blog\Assistants\IncompletePosts\DataSource\IncompletePostsDataSource',
            'settingsHandlerClass' => 'Blog\Assistants\IncompletePosts\SettingsHandler\IncompletePostsSettingsHandler',
            'reloadStructure' => true,
            "priority" => 830,
            'shortDescription' => 'This assistant fixes incomplete posts.',
            'topics' => [
                'omni-channel.blog.blog-debug',
            ],
            'options' => [
                'data' => [
                    'urlName',
                    'id'
                ]
            ],

            'steps' => [
                'step1' => [
                    'title' => 'Debug assistant',
                    'description' => 'This is a debug assistant, do not use it if you do not know what you\'re doing',
                    'sections' => [
                        [
                            'title' => 'Fix post',
                            'description' => 'Fix incomplete post',
                            'form' => [
                                'agreement' => [
                                    'type' => 'checkbox',
                                    'options' => [
                                        'required' => true,
                                        'name' => 'Fix post',
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
