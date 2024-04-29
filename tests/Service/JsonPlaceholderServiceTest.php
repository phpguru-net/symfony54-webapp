<?php

namespace App\Tests\Service;

use App\Service\JsonPlaceholderService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class JsonPlaceholderServiceTest extends TestCase
{
    private $jsonPlaceholderService;

    protected function setUp(): void
    {
        $endpoints = [
            'posts' => 'https://jsonplaceholder.typicode.com/posts'
        ];

        $responses = [
            new MockResponse(json_encode([
                ['id' => 1, 'title' => 'Test Post', 'body' => 'This is a test post', 'userId' => 1]
            ])),
        ];

        $httpClient = new MockHttpClient($responses, $endpoints['posts']);
        $this->jsonPlaceholderService = new JsonPlaceholderService($httpClient, $endpoints);
    }

    /**
     * @throws \Exception
     */
    public function testFetchPosts()
    {
        $posts = $this->jsonPlaceholderService->getPosts();
        $this->assertCount(1, $posts);
        $this->assertEquals('Test Post', $posts[0]['title']);
    }
}
