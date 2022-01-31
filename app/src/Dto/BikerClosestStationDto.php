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
        public readonly float $distanceFromStation
    ) {}
}