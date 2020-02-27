<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 27/02/2020
 * Time: 11:26
 */

namespace Blog\Assistants\QuickPreviews\SettingsHandler;

use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;
use Plenty\Modules\Wizard\Contracts\WizardSettingsHandler;

/**
 * Class QuickPreviewsSettingsHandler
 * @package Blog\Assistants\QuickPreviews\SettingsHandler
 */
class QuickPreviewsSettingsHandler implements WizardSettingsHandler
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function handle(array $parameters)
    {
        /** @var BlogPostRepositoryContract $repository */
        $repository = pluginApp(BlogPostRepositoryContract::class);

        $posts = $parameters['data'];
        unset($posts['from'], $posts['to']);

        foreach($posts as $post) {
            if(empty($post['id'])) continue;

            $this->avoidEmptyValues($post);

            $updatedPostData = [
                'post' => [
                    'shortDescription' => $post['preview'],
                    'title' => $post['title'],
                    'body' => $post['body']
                ]
            ];

            $repository->updatePost($updatedPostData, $post['id']);
        }

        return true;
    }

    /**
     * @param $post
     */
    private function avoidEmptyValues(&$post)
    {
        if(empty($post['preview'])) $post['preview'] = 'Debug assistant - Previews can not be empty so we fill this one automatically with this message';
        if(empty($post['title'])) $post['title'] = 'Debug assistant - Titles can not be empty so we fill this one automatically with this message';
    }
}
