<?php

declare(strict_types=1);

namespace Tests\DistanceCalculator;

use App\Application\ApiClient\CityBikeApiClient;
use App\Application\ApiClient\Exception\InvalidApiResponse;
use App\Application\BikeStationsService;
use PHPUnit\Framework\TestCase;

class BikeStationsServiceTest extends TestCase
{
    /**
     * @dataProvider correctApiResponseProvider
     */
    public function testGetAvailableBikeStationsWithCorrectResponse(array $apiData): void
    {
        $cityBikeApiClient = $this->createCityBikeApiClient($apiData);

        $bikeStationService = new BikeStationsService($cityBikeApiClient);
        $bikeStations = $bikeStationService->getAvailableBikeStations('bycyklen');

        foreach ($bikeStations as $bikeStation) {
            $this->assertEquals(
                $apiData['network']['stations'][$bikeStations->key()]['extra']['address'],
                $bikeStation->address
            );
            $this->assertEquals(
                $apiData['network']['stations'][$bikeStations->key()]['latitude'],
                $bikeStation->latitude
            );
            $this->assertEquals(
                $apiData['network']['stations'][$bikeStations->key()]['longitude'],
                $bikeStation->longitude
            );
            $this->assertEquals(
                $apiData['network']['stations'][$bikeStations->key()]['free_bikes'],
                $bikeStation->freeBikesCount
            );
        }
    }

    public function testGetAvailableBikeStationsWithIncorrectResponse(): void
    {
        $cityBikeApiClient = $this->createCityBikeApiClientWithException();

        $bikeStationService = new BikeStationsService($cityBikeApiClient);
        $bikeStations = $bikeStationService->getAvailableBikeStations('bycyklen');

        $this->assertEquals(
            null,
            $bikeStations->getReturn()
        );
    }

    public function correctApiResponseProvider(): array
    {
        return [
            [
                [
                    'network' => [
                        'stations' => [
                            [
                                'extra' => [
                                    'address' => 'Staunings Plads, København, 1606 Copenhagen',
                                ],
                                'free_bikes' => 0,
                                'latitude' => 55.67784881591797,
                                'longitude' => 12.562789916992188,
                            ],
                        ],
                    ],
                ],
            ],
            [
                [
                    'network' => [
                        'stations' => [
                            [
                                'extra' => [
                                    'address' => 'Dag Hammarskjölds Allé 34, København, 2100 Copenhagen',
                                ],
                                'free_bikes' => 0,
                                'latitude' => 55.69546890258789,
                                'longitude' => 12.580940246582031,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function createCityBikeApiClient($responseData): CityBikeApiClient
    {
        $cityBikeApiClient = $this->createMock(CityBikeApiClient::class);
        $cityBikeApiClient->expects($this->once())
            ->method('getNetworkData')
            ->with('bycyklen')
            ->willReturn($responseData);

        return $cityBikeApiClient;
    }

    private function createCityBikeApiClientWithException(): CityBikeApiClient
    {
        $cityBikeApiClient = $this->createMock(CityBikeApiClient::class);
        $cityBikeApiClient->expects($this->once())
            ->method('getNetworkData')
            ->with('bycyklen')
            ->willThrowException(new InvalidApiResponse());

        return $cityBikeApiClient;
    }
}