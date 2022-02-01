<?php

declare(strict_types=1);

namespace App\Application\ApiClient;

use App\Application\ApiClient\Exception\InvalidApiResponse;
use App\Application\ApiClient\Validation\ResponseValidator;
use GuzzleHttp\Exception\GuzzleException;

class CityBikeApiClient extends AbstractApiClient
{
    private const API_CALL_RETRY_MAX = 1;
    private const API_ENDPOINT_NETWORK_DATA = 'http://api.citybik.es/:VERSION:/networks/:NETWORK_ID:';

    public function __construct(
        private string $version = 'v2',
        private ResponseValidator $responseValidator = new ResponseValidator(),
    ) {
        parent::__construct();
    }

    /**
     * @throws InvalidApiResponse
     */
    public function getNetworkData(string $network, int $callAttempt = 1): array
    {
        if ($callAttempt > self::API_CALL_RETRY_MAX) {
            throw new InvalidApiResponse('Could not get response frm API');
        }

        try {
            $responseData = $this->apiCall(
                'GET',
                str_replace(
                    [':VERSION:', ':NETWORK_ID:'],
                    [$this->version, $network],
                    self::API_ENDPOINT_NETWORK_DATA
                )
            );
        } catch (GuzzleException) {
            return $this->getNetworkData($network, ++$callAttempt);
        }

        if (is_array($responseData) && !isset($responseData['errors'])) {
            $this->responseValidator->validateNetworkData($responseData);

            return $responseData;
        }

        return $this->getNetworkData($network, ++$callAttempt);
    }
}