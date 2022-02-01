<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\DistanceCalculator\DistanceCalculator;
use App\Dto\BikerClosestStationDto;
use App\Entity\Biker;

class CityBikeService
{
    public function __construct(
        private BikeStationsService $bikeStationsService = new BikeStationsService(),
        private DistanceCalculator $distanceCalculator = new DistanceCalculator(),
    ) {}

    public function findClosestStationForBiker(Biker $biker, string $network): ?BikerClosestStationDto
    {
        // List of stations should be cached to avoid multiple API calls
        $bikeStationsCollection =
            $this->bikeStationsService->getAvailableBikeStations($network);

        if (!$bikeStationsCollection->valid()) {
            return null;
        }

        $shortestDistance = null;
        $closesStation = null;

        foreach ($bikeStationsCollection as $bikeStation) {
            $distance = $this->distanceCalculator->calculateDistanceBetweenPoints(
                $biker->latitude,
                $biker->longitude,
                $bikeStation->latitude,
                $bikeStation->longitude,
            );

            if ($shortestDistance === null || $distance < $shortestDistance) {
                $shortestDistance = $distance;
                $closesStation = $bikeStation;
            }
        }

        return new BikerClosestStationDto(
            $biker,
            $closesStation,
            $shortestDistance
        );
    }
}