<?php

namespace Blog\Assistants\ReindexPosts\SettingsHandler;

use Blog\AssistantServices\AssistantsService;
use Exception;
use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Wizard\Contracts\WizardSettingsHandler;

/**
 * Class ReindexPostsSettingsHandler
 * @package Blog\Assistants\ReindexPosts\SettingsHandler
 */
class ReindexPostsSettingsHandler implements WizardSettingsHandler
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function handle(array $parameters)
    {
        /** @var AssistantsService $assistantsService */
        $assistantsService = pluginApp(AssistantsService::class);

        /** @var BlogPostRepositoryContract $blogRepository */
        $blogRepository = pluginApp(BlogPostRepositoryContract::class);

        $posts = $assistantsService->getDynamoDbPosts();

        // Create a list of posts with their count
        foreach ($posts as $post) {
            $blogRepository->updatePost([], $post['id']);
        }

        return true;
    }
}
