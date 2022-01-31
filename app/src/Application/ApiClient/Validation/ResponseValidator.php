<?php

declare(strict_types=1);

namespace App\Application\ApiClient\Validation;

use App\Application\ApiClient\Exception\InvalidApiResponse;

class ResponseValidator
{
    private const REQUIRED_STATION_DATA = [
        'extra',
        'free_bikes',
        'latitude',
        'longitude',
    ];

    /**
     * Normally I would use schema validation library that also provides type coercion
     * Simple data validation to save time
     *
     * @throws InvalidApiResponse
     */
    public function validateNetworkData(array $networkData): void
    {
        if (
            empty($networkData['network']) ||
            empty($networkData['network']['stations'])
        ) {
            throw new InvalidApiResponse('Invalid API response');
        }

        foreach ($networkData['network']['stations'] as $station) {
            foreach (self::REQUIRED_STATION_DATA as $requiredResponseElement) {
                if (!in_array($requiredResponseElement, array_keys($station))) {
                    throw new InvalidApiResponse('Invalid API response');
                }
           }
        }
    }
}