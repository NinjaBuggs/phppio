<?php
declare(strict_types=1);

namespace phppio;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Base Engine client for Event
 */
abstract class BaseClient implements ClientInterface
{
    const GET = 'GET';
    const POST = 'POST';

    public $client;

    /**
     * $baseUrl Base URL to the server
     * $timeout Timeout of the request in seconds. Use 0 to wait indefinitely
     * $connectTimeout Number of seconds to wait while trying to connect to a server
     */
    public function __construct(string $baseUrl, float $timeout, float $connectTimeout)
    {
        $this->client = $this->createClient($baseUrl, $timeout, $connectTimeout);
    }

    /**
     * Get the status of the Event Server or Engine Instance
     */
    public function getStatus(): string
    {
        return $this->client->get('/')->getBody();
    }

    /**
     * @throws PredictionIOException
     */
    public function sendRequest(string $method, string $endpoint, array $data): array
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($data)
        ];

        try {
            $response = $this->client->request($method, $endpoint, $options);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            throw new PredictionIOException($e->getMessage());
        }
    }

    private function createClient(string $baseUrl, float $timeout, float $connectTimeout): ClientInterface
    {
        return new Client([
            'base_uri' => $baseUrl,
            'timeout' => $timeout,
            'connect_timeout' => $connectTimeout
        ]);
    }
}
