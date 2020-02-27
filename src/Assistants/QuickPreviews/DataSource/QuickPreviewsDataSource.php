<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 27/02/2020
 * Time: 11:26
 */

namespace Blog\Assistants\QuickPreviews\DataSource;

use Blog\AssistantServices\AssistantsService;
use Exception;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Blog\Models\BlogPost;
use Plenty\Modules\Wizard\Services\DataSources\BaseWizardDataSource;

/**
 * Class QuickPreviewsDataSource
 * @package Blog\Assistants\QuickPreviews\DataSource
 */
class QuickPreviewsDataSource extends BaseWizardDataSource
{

    /**
     * @return array
     */
    private function getEntities()
    {
        $entities = [];
        /** @var AssistantsService $assistantsService */
        $assistantsService = pluginApp(AssistantsService::class);

        $posts = $assistantsService->getDynamoDbPosts();

        // Create a list of posts with their count
        $page = 1;
        $pageSize = 50;
        $postCount = 0;
        foreach($posts as $post) {
            $postCount++;


            // Set "from" and "to"
            $postNumber = ($page - 1) * $pageSize + $postCount;

            if($postCount == 1) $entities[$page]['from'] = $postNumber;
            $entities[$page]['to'] = $postNumber;

            // Add data to each post
            $entities[$page][$postCount] = [
                'title' => $post['data']['post']['title'],
                'urlName' => $post['data']['post']['urlName'],
                'id' => $post['id'],
                'preview' => $post['data']['post']['shortDescription'],
                'body' => $post['data']['post']['body'],
            ];

            // Reset batch
            if($postCount % $pageSize == 0) {
                $page++;
                $postCount = 0;
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
     * @return array|void
     */
    public function getByOptionId(string $optionId = 'default')
    {
        $dataStructure = $this->dataStructure;
        $dataStructure['data'] = (object)$this->getEntities()[$optionId];
        return $dataStructure;
    }
    
    /**
     * @param string $optionId
     * @throws Exception
     */
    public function deleteDataOption(string $optionId)
    {
        throw new Exception('You can not delete a group of posts');
    }

}
