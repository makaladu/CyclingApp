<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\ApiClient\CityBikeApiClient;
use App\Application\ApiClient\Exception\InvalidApiResponse;
use App\Entity\BikeStation;
use Generator;

class BikeStationsService
{
    public function __construct(
        private CityBikeApiClient $cityBikeApiClient = new CityBikeApiClient(),
    ) {}

    /**
     * @throws InvalidApiResponse
     */
    public function getAvailableBikeStations(string $network): Generator
    {
        $cityBikeApiData = $this->cityBikeApiClient->getNetworkData($network);

        foreach ($cityBikeApiData['network']['stations'] as $stationData) {
            yield new BikeStation(
                $stationData['extra']['address'],
                (float)$stationData['latitude'],
                (float)$stationData['longitude'],
                (int)$stationData['free_bikes'],
            );
        }
    }
}