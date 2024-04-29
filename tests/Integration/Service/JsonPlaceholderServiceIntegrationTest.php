<?php

namespace App\Tests\Integration\Service;

use App\Service\JsonPlaceholderService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JsonPlaceholderServiceIntegrationTest extends WebTestCase
{
    private $jsonPlaceholderService;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->jsonPlaceholderService = $container->get(JsonPlaceholderService::class);
    }

    public function testFetchPosts()
    {
        $posts = $this->jsonPlaceholderService->getPosts();
        $this->assertIsArray($posts);
        $this->assertNotEmpty($posts);
        // Add more specific assertions here, such as checking the structure of the posts
    }
}
