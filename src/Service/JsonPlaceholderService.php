<?php

namespace  App\Service;

use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class JsonPlaceholderService {
    private $httpClient;
    private $endpoints;

    public function __construct(HttpClientInterface $httpClient, array $endpoints)
    {
        $this->httpClient = $httpClient;
        $this->endpoints = $endpoints;
    }

    public function getEndpoint(string $key)
    {
        if (!isset($this->endpoints[$key])) {
            throw new \InvalidArgumentException("No endpoint configured for key: {$key}");
        }

        return $this->endpoints[$key];
    }

    /**
     * @throws \Exception
     */
    public function getPosts(){
        try {
            $endpoint = $this->getEndpoint(EndpointKeys::POSTS);
            $response = $this->httpClient->request('GET', $endpoint);
            foreach ($this->httpClient->stream($response) as $chunk) {
                if ($chunk->isLast()) {
                    // This is the last chunk of the response
                    $content = $response->getContent();
                    return json_decode($content, true);
                }
            }
        } catch (TransportExceptionInterface $e) {
            // This exception is thrown on a network error
            throw new \Exception('Network error occurred.');
        } catch (HttpExceptionInterface  $e) {
            throw new \Exception('Server returned an error response.');
        } catch(DecodingExceptionInterface $e){
            throw new \Exception('Failed to decode response.');
        } catch(\Throwable $e){
            // Catch other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
