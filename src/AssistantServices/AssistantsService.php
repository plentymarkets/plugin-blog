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
     * @return mixed
     */
    public function getElasticSearchPosts()
    {
        if (!$this->elasticSearchIsPopulated) {
            $this->populateElasticSearchList();
        }

        return $this->elasticSearchPosts;
    }

    
    /**
     * Populates Dynamo DB list
     */
    private function populateDynamoDbList()
    {
        $this->dynamoDbIsPopulated = true;

        /** @var BlogPostRepositoryContract $repository */
        $repository = pluginApp(BlogPostRepositoryContract::class);

        $posts = $repository->listPosts(1, 9999);
        $this->dynamoDbPosts = $posts['entries'];
    }


    /**
     * Populates Elastic Search list
     */
    private function populateElasticSearchList()
    {
        $this->elasticSearchIsPopulated = true;

        /** @var BlogPostRepositoryContract $repository */
        $repository = pluginApp(BlogPostRepositoryContract::class);

        $posts = $repository->listPosts(1, 9999, ['rawElasticSearch' => true]);
        $this->elasticSearchPosts = $posts;
    }

}
