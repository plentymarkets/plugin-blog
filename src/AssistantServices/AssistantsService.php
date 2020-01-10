<?php
/**
 * Created by PhpStorm.
 * User: Cristian Benescu
 * Date: 06/11/2019
 * Time: 14:08
 */

namespace Blog\AssistantServices;

use Plenty\Modules\Blog\Contracts\BlogPostRepositoryContract;

class AssistantsService
{
    /**
     * All posts in Dynamo DB
     */
    protected $dynamoDbPosts;

    /**
     * Is Dynamo DB posts list populated or in course of being populated?
     */
    protected $dynamoDbIsPopulated = false;

    /**
     * All posts in Elastic Search
     */
    protected $elasticSearchPosts;

    /**
     * Is Elastic Search posts list populated or in course of being populated?
     */
    protected $elasticSearchIsPopulated = false;

    /**
     * @return mixed
     */
    public function getDynamoDbPosts()
    {
        if (!$this->dynamoDbIsPopulated) {
            $this->populateDynamoDbList();
        }

        return $this->dynamoDbPosts;
    }

    /**
     * Populates Dynamo DB list
     */
    private function populateDynamoDbList()
    {
        $this->dynamoDbIsPopulated = true;

        $repository = pluginApp(BlogPostRepositoryContract::class);

        $posts = $repository->listPosts(1, 9999);
        $this->dynamoDbPosts = $posts['entries'];
    }

}
