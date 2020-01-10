<?php

namespace Blog\Assistants\DuplicatedPosts\DataSource;

use Blog\AssistantServices\AssistantsService;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Wizard\Services\DataSources\BaseWizardDataSource;

/**
 * Class DuplicatedPostsDataSource
 * @package Blog\Assistants\DuplicatedPosts\DataSource
 */
class DuplicatedPostsDataSource extends BaseWizardDataSource
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
        foreach ($posts as $post) {
            $urlName = $post['data']['post']['urlName'];
            $entities[$urlName]['count'] = empty($entities[$urlName]['count']) ? 1 : $entities[$urlName]['count'] + 1;
            $entities[$urlName]['urlName'] = $urlName;
            $entities[$urlName]['posts'][] = $post;
        }

        // Leave only duplicates
        foreach ($entities as $key => $entity) {

            if ($entity['count'] === 1) {
                // Remove posts that are not duplicated
                unset($entities[$key]);
            } else {
                // Mark the post that was edited as corect
                foreach ($entity['posts'] as $post) {
                    $urlName = $post['data']['post']['urlName'];
                    if ($post['data']['post']['shortDescription'] != 'Preview') {
                        $entities[$urlName]['corect'] = $post['id'];
                    }
                }
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
        if (array_key_exists($optionId, $entities)) {
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
        /** @var BlogPostRepositoryContract $repository */
        $repository = pluginApp(BlogPostRepositoryContract::class);
        $entities = $this->getEntities();

        if (!array_key_exists($optionId, $entities)) throw new \Exception('Blog post not found!');
        $optionData = $entities[$optionId];

        $deactivatablePosts = $optionData['posts'];
        $count = 0;

        try {

            foreach ($deactivatablePosts as $post) {
                $count++;

                // Skip this post if it's marked as corect
                // Or the first one if there is no corect post
                if (!empty($optionData['corect'])) {
                    if ($post['id'] == $optionData['corect']) continue;
                } else if ($count == 1) {
                    continue;
                }

                // Broken posts often can't be updated so their preview is "Preview"
                // Older broken posts did not have any shortDescription ( preview ) at all so we're fixing those too
                $data = [
                    'post' => [
                        'active' => 'false',
                        'title' => 'DEACTIVATED ' . $post['data']['post']['title'],
                        'urlName' => $post['data']['post']['urlName'] . '-deactivated-' . $count
                    ]
                ];

                if (empty($post['data']['post']['shortDescription'])) {
                    $data['post']['shortDescription'] = 'Preview';
                }

                $repository->updatePost($data, $post['id']);

            }
        } catch (\Exception $exception) {
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
