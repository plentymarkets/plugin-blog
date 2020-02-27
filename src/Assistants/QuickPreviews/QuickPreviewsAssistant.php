<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 27/02/2020
 * Time: 11:26
 */

namespace Blog\Assistants\QuickPreviews;

use Plenty\Modules\Wizard\Services\WizardProvider;

/**
 * Class QuickPreviewsAssistant
 * @package Blog\Assistants\QuickPreviews
 */
class QuickPreviewsAssistant extends WizardProvider
{

    /**
     * The wizard structure
     *
     * @return array
     */
    protected function structure()
    {

        return [
            'title' => 'Quick previews',
            'key' => 'blog-quick-previews',
            'translationNamespace' => 'Blog',
            'dataSource' => 'Blog\Assistants\QuickPreviews\DataSource\QuickPreviewsDataSource',
            'settingsHandlerClass' => 'Blog\Assistants\QuickPreviews\SettingsHandler\QuickPreviewsSettingsHandler',
            'reloadStructure' => true,
            "priority" => 500,
            'shortDescription' => 'This assistant lists posts to easily edit their previews.',
            'topics' => [
                'omni-channel.blog',
            ],
            'options' => [
                'data' => [
                    'from',
                    'to'
                ]
            ],

            'steps' => [
                'step1' => [
                    'title' => 'Debug assistant',
                    'description' => 'This is a debug assistant, do not use it if you do not know what you\'re doing',
                    'sections' => [
                        [
                            'title' => 'I understand',
                            'description' => '',
                            'form' => [
                                'agreement' => [
                                    'type' => 'checkbox',
                                    'options' => [
                                        'required' => true,
                                        'name' => 'I understand, I want to continue',
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'postsList' => [
                    'title' => 'This is where you can edit your posts faster',
                    'description' => 'Please focus on editing the previews. Only edit the body and the title of the post if absolutely necessary.',
                    'sections' => $this->buildSections()
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function buildSections()
    {
        $sections = [];

        for ($i = 1; $i <= 50; $i++) {
            $sections[] = [
                'form' => [
                    $i => [
                        "type" => "horizontal",
                        "width" => "col-12",
                        "children" => [
                            "title" => [
                                "type" => "text",
                                "width" => "col-12",
                                "options" => [
                                    "name" => "Title"
                                ]
                            ],
                            "urlName" => [
                                "type" => "text",
                                "width" => "col-6",
                                "options" => [
                                    "name" => "URL",
                                    "isReadonly" => "true",
                                ]
                            ],
                            "id" => [
                                "type" => "text",
                                "width" => "col-6",
                                "options" => [
                                    "name" => "Post ID",
                                    "isReadonly" => "true",
                                ]
                            ],
                            "preview" => [
                                "type" => "textarea",
                                "options" => [
                                    "name" => "Preview",
                                    "maxRows" => 10
                                ]
                            ],
                            "body" => [
                                "type" => "codeEditor",
                                "options" => [
                                    "name" => "Body",
                                    "fixedHeight" => 250,
                                ]
                            ],
                        ]
                    ],
                ]
            ];
        }

        return $sections;
    }
}
