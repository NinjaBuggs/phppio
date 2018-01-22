<?php
declare(strict_types=1);

namespace phppio;

/**
 * Client for an Engine instance
 */
class EngineClient extends BaseClient
{
    public function __construct(
        string $baseUrl = "http://localhost:8000",
        float $timeout = 0,
        float $connectTimeout = 5
    ) {
        parent::__construct($baseUrl, $timeout, $connectTimeout);
    }

    /**
     * @throws PredictionIOException
     */
    public function sendQuery(array $query): array
    {
        return $this->sendRequest(BaseClient::POST, "/queries.json", $query);
    }
}
