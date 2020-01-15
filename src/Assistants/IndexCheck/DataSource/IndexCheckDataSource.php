<?php

namespace Blog\Assistants\IndexCheck\DataSource;

use Blog\AssistantServices\AssistantsService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Wizard\Services\DataSources\BaseWizardDataSource;

/**
 * Class IndexCheckDataSource
 * @package Blog\Assistants\IndexCheck\DataSource
 */
class IndexCheckDataSource extends BaseWizardDataSource
{

    /**
     * @return array
     */
    private function getEntities()
    {
        $entities = [];
        /** @var AssistantsService $assistantsService */
        $assistantsService = pluginApp(AssistantsService::class);

        $dynamoPosts = $assistantsService->getDynamoDbPosts();
        $elasticPosts = $assistantsService->getElasticSearchPosts();

        foreach($dynamoPosts as $dynamoIndex => $dynamoPost) {
            foreach($elasticPosts as $elasticIndex => $elasticPost) {
                if($dynamoPost['id'] == $elasticPost['_id']) {
                    unset($dynamoPosts[$dynamoIndex], $elasticPosts[$elasticIndex]);
                    break;
                }
            }
        }

        foreach($dynamoPosts as $dynamoPost) {
            $entities[$dynamoPost['id']] = [
                'issue' => 'Not indexed',
                'id' => $dynamoPost['id']
            ];
        }

        foreach($elasticPosts as $elasticPost) {
            $entities[$elasticPost['_id']] = [
                'issue' => 'Indexed but original deleted',
                'id' => $elasticPost['_id']
            ];
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
        if (array_key_exists($optionId, $entities)) {
            $dataStructure['data'] = (object)$entities[$optionId];
        }

        return $dataStructure;

    }

}
