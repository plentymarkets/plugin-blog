<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 29/01/2019
 * Time: 10:18
 */

namespace Blog\Assistants\BlogLanding;

use Blog\Services\BlogService;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Modules\Wizard\Services\WizardProvider;

/**
 * Class BlogLandingAssistant
 * @package Blog\Assistants\BlogLanding
 */
class BlogLandingAssistant extends WizardProvider
{

    /**
     * The wizard structure
     *
     * @return array
     */
    protected function structure() {

        return [
            'title' => 'Assistant.title',
            'key' => 'blog-landing-page',
            'translationNamespace' => 'Blog',
            'dataSource' => 'Blog\Assistants\BlogLanding\DataSource\BlogLandingDataSource',
            'settingsHandlerClass' => 'Blog\Assistants\BlogLanding\SettingsHandler\BlogLandingSettingsHandler',
            'reloadStructure' => true,
            'shortDescription' => 'Assistant.description',
            'topics' => [
                'omni-channel.blog',
            ],
            'options' => [
                'data' => [
                    'urlName'
                ],
                'pluginSetId' => [
                    'type' => 'select',
                    'options' => [
                        'name' => 'Assistant.pluginSet',
                        'required' => true,
                        'listBoxValues' => $this->listPluginSets()
                    ]
                ],
                'languageCode' => [
                    'type' => 'select',
                    'options' => [
                        'name' => 'Assistant.language',
                        'required' => true,
                        'listBoxValues' => $this->languages()
                    ]
                ]
            ],

            'steps' => [
                'step1' => [
                    'title' => 'Assistant.landingPageStepTitle',
                    'description' => 'Assistant.landingPageStepDescription',
                    'sections' => [
                        [
                            'title' => 'Assistant.entrypointSectionTitle',
                            'description' => 'Assistant.entrypointSectionDescription',
                            'form' => [
                                'entrypointMessage' => [
                                    'type' => 'text',
                                    'options' => [
                                        'name' => 'Assistant.entrypointMessage'
                                    ]
                                ],
                                'backToStoreMessage' => [
                                    'type' => 'text',
                                    'options' => [
                                        'name' => 'Assistant.entrypointExitMessage'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'title' => 'Assistant.landingSectionTitle',
                            'description' => 'Assistant.landingSectionDescription',
                            'form' => [
                                'urlName' => [
                                    'type' => 'text',
                                    'defaultValue' => 'blog',
                                    'options' => [
                                        'name' => 'Assistant.customUrl',
                                        'minLength' => 3,
                                        'maxLength' => 20,
                                        'required' => true,
                                        'pattern' => '([a-z0-9-_])+'
                                    ]
                                ],
                                'landingTitle' => [
                                    'type' => 'text',
                                    'options' => [
                                        'name' => 'Assistant.landingTitle'
                                    ]
                                ],
                                'landingMetaTitle' => [
                                    'type' => 'text',
                                    'options' => [
                                        'name' => 'Assistant.landingMetaTitle'
                                    ]
                                ],
                                'landingMetaDescription' => [
                                    'type' => 'text',
                                    'options' => [
                                        'name' => 'Assistant.landingMetaDescription'
                                    ]
                                ],
                                'landingMetaKeywords' => [
                                    'type' => 'text',
                                    'options' => [
                                        'name' => 'Assistant.landingMetaKeywords'
                                    ]
                                ],
                                'landingRobots' => [
                                    'type' => 'select',
                                    'defaultValue' => 'INDEX_FOLLOW',
                                    'options' => [
                                        'name' => 'Assistant.landingRobots',
                                        'required' => true,
                                        'listBoxValues' => [
                                            [
                                                'caption' => 'Assistant.indexfollow',
                                                'value' => 'INDEX_FOLLOW'
                                            ],
                                            [
                                                'caption' => 'Assistant.noindexfollow',
                                                'value' => 'NOINDEX_FOLLOW'
                                            ],
                                            [
                                                'caption' => 'Assistant.indexnofollow',
                                                'value' => 'INDEX_NOFOLLOW'
                                            ],
                                            [
                                                'caption' => 'Assistant.noindexnofollow',
                                                'value' => 'NOINDEX_NOFOLLOW'
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'plugin_build' => [
                    'title' => 'Assistant.pluginBuildTitle',
                    'sections' => [
                        [
                            'title' => 'Assistant.pluginBuildSectionTitle',
                            'description' => 'Assistant.pluginBuildSectionDescription',
                            'form' => [
                                'agreement' => [
                                    'type' => 'checkbox',
                                    'options' => [
                                        'required' => true,
                                        'name' => 'Assistant.pluginBuildAgreement',
                                    ]
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }


    /**
     * List of plugin sets for options
     *
     * @return array
     */
    private function listPluginSets()
    {
        $allSets = pluginApp(PluginSetRepositoryContract::class)->list();

        $selects = [];

        $selects[] = [
            'caption' => ''
        ];

        foreach($allSets as $set) {
            $selects[] = [
                'caption' => $set->name,
                'value' => $set->id
            ];
        }

        return $selects;
    }

    /**
     * @return array
     */
    private function languages()
    {
        $blogService = pluginApp(BlogService::class);
        $languages = $blogService->getLanguages();

        $selects = [];

        $selects[] = [
            'caption' => ''
        ];

        foreach($languages as $language) {
            $selects[] = [
                'caption' => "Languages.$language",
                'value' => $language
            ];
        }

        return $selects;

    }


}
