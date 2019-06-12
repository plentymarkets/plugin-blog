<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 30/01/2019
 * Time: 17:00
 */

namespace Blog\Assistants\BlogLanding\DataSource;

use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Modules\PluginMultilingualism\Contracts\PluginTranslationRepositoryContract;
use Plenty\Modules\Wizard\Services\DataSources\BaseWizardDataSource;

/**
 * Class BlogLandingDataSource
 * @package Blog\Assistants\BlogLanding\DataSource
 */
class BlogLandingDataSource extends BaseWizardDataSource
{

    /**
     * @return array
     */
    private function getEntities()
    {
        $entities = [];
        $translationRepository = pluginApp(PluginTranslationRepositoryContract::class);

        $filters = [
            'pluginName' => 'Blog'
        ];

        $allTranslations = $translationRepository->listTranslations($filters);

        foreach($allTranslations as $key => $entity) {
            $optionId = $entity['pluginSetId'].'_'.$entity['languageCode'];
            if($entity['fileName'] == 'Landing.properties') {
                if(empty($entities[$optionId]['pluginSetId'])) $entities[$optionId]['pluginSetId'] = $entity['pluginSetId'];
                if(empty($entities[$optionId]['languageCode'])) $entities[$optionId]['languageCode'] = $entity['languageCode'];

                $entities[$optionId][$entity['key']] = $entity['value'];
                $entities[$optionId]['translationIds'][] = ['id' => $entity['id']];
            }
        }

        return $entities;
    }


    /**
     * @return array
     */
    public function getIdentifiers()
    {
        return array_keys($this->getEntities());
    }


    /**
     * @return array
     */
    public function get()
    {
        $dataStructure = $this->dataStructure;
        $dataStructure['data'] = (object)$this->getEntities();
        return $dataStructure;
    }

    /**
     * @param string $optionId
     * @return array
     */
    public function getByOptionId(string $optionId = 'default')
    {
        $dataStructure = $this->dataStructure;
        $entities = $this->getEntities();

        // If this option already exists
        if(array_key_exists($optionId, $entities)) {
            $dataStructure['data'] = (object)$entities[$optionId];
        }

        return $dataStructure;

    }

    /**
     * @param string $optionId
     * @throws \Exception
     */
    public function deleteDataOption(string $optionId)
    {
        $translationRepository = pluginApp(PluginTranslationRepositoryContract::class);
        $entities = $this->getEntities();

        if(array_key_exists($optionId, $entities)) {
            $translationIds = $entities[$optionId]['translationIds'];
        }else{
            throw new \Exception('Option not found!');
        }

        try{
            foreach($translationIds as $translationId) {
                $translationRepository->deleteTranslation($translationId['id']);
            }
        }catch(\Exception $exception){
            throw $exception;
        }
    }
}
