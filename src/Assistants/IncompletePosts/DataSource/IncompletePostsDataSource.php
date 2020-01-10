<?php

namespace Blog\Assistants\IncompletePosts\DataSource;

use Blog\AssistantServices\AssistantsService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Blog\Models\BlogPost;
use Plenty\Modules\Wizard\Services\DataSources\BaseWizardDataSource;

/**
 * Class IncompletePostsDataSource
 * @package Blog\Assistants\IncompletePosts\DataSource
 */
class IncompletePostsDataSource extends BaseWizardDataSource
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
        foreach($posts as $post) {
            $preview = $post['data']['post']['shortDescription'];

            if(empty($preview)){
                $id = $post['id'];
                $entities[$id]['urlName'] = $post['data']['post']['urlName'];
                $entities[$id]['id'] = $id;
                $entities[$id]['shortDescription'] = $post['data']['post']['shortDescription'];
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
     * @throws \Exception
     */
    public function deleteDataOption(string $optionId)
    {
        /** @var BlogPostRepositoryContract $repository */
        $repository = pluginApp(BlogPostRepositoryContract::class);

        try{

            /** @var BlogPost $post */
            $post = $repository->getPost($optionId);
            $preview = $post->data['post']['shortDescription'];

            if(empty($preview)){
                $data['post']['shortDescription'] = 'Preview';
                $repository->updatePost($data, $optionId);
            }

        }catch(\Exception $exception){
            throw $exception;
        }
    }

    /**
     * @param string $optionId
     * @param array $data
     * @throws \Exception
     */
    public function finalize(string $optionId, array $data = [])
    {
        $this->deleteDataOption($optionId);
    }
}
