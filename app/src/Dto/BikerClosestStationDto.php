<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Biker;
use App\Entity\BikeStation;

class BikerClosestStationDto
{
    public function __construct(
        public readonly Biker $biker,
        public readonly BikeStation $closestStation,
        public readonly float $distanceFromStation,
    ) {}

    public function toString(): string
    {
        return
            "distance: " . $this->distanceFromStation . PHP_EOL .
            "address: " . $this->closestStation->address . PHP_EOL .
            "free_bike_count: " . $this->closestStation->freeBikesCount . PHP_EOL .
            "biker_count: " . $this->biker->count . PHP_EOL;

    }
}