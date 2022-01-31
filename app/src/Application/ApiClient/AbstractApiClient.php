<?php

declare(strict_types=1);

namespace App\Application\ApiClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class AbstractApiClient
{
    public function __construct(
        private Client $client = new Client(),
    ) {}

    /**
     * @throws GuzzleException
     */
    protected function apiCall(string $httpMethod, string $endpoint, array $options = []): ?array
    {
        $response = $this->client->request($httpMethod, $endpoint, $options);

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);

        if (!is_array($result)) {
            return null;
        }

        return $result;
    }
}