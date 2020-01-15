<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 29/01/2019
 * Time: 10:18
 */

namespace Blog\Assistants\IndexCheck;

use Blog\Services\BlogService;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Modules\Wizard\Services\WizardProvider;

/**
 * Class IndexCheck
 * @package Blog\Assistants\IndexCheck
 */
class IndexCheckAssistant extends WizardProvider
{

    /**
     * The wizard structure
     *
     * @return array
     */
    protected function structure() {

        return [
            'title' => '3. Check Index',
            'key' => 'blog-check-index',
            'translationNamespace' => 'Blog',
            'dataSource' => 'Blog\Assistants\IndexCheck\DataSource\IndexCheckDataSource',
            'settingsHandlerClass' => 'Blog\Assistants\IndexCheck\SettingsHandler\IndexCheckSettingsHandler',
            'reloadStructure' => true,
            "priority" => 810,
            'shortDescription' => 'This assistant checks Elastic Search index.',
            'topics' => [
                'omni-channel.blog.blog-debug',
            ],
            'options' => [
                'data' => [
                    'issue',
                    'id'
                ]
            ],

            'steps' => [
                'step1' => [
                    'title' => 'Debug assistant',
                    'description' => 'This is a debug assistant, do not use it if you do not know what you\'re doing',
                    'sections' => [
                        [
                            'title' => 'This assistant should not be finalised, it only checks your posts',
                            'description' => 'Proceeding will not do anything, this assistant\'s only purpose is to verify posts',
                            'form' => [
                                'agreement' => [
                                    'type' => 'checkbox',
                                    'options' => [
                                        'required' => true,
                                        'name' => 'I understand that finalising this assistant does nothing',
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
