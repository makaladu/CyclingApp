<?php

declare(strict_types=1);

namespace App\Entity;

class Biker
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly int $count,
        private ?BikeStation $closestStation = null
    ) {}

    public function getClosestStation(): ?BikeStation
    {
        return $this->closestStation;
    }

    public function setClosestStation(?BikeStation $closestStation): void
    {
        $this->closestStation = $closestStation;
    }
}