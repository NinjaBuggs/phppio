<?php
declare(strict_types=1);

namespace phppio;

interface ClientInterface
{
    public function sendRequest(string $method, string $endpoint, array $data): array;
}
