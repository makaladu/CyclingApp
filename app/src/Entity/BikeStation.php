<?php

declare(strict_types=1);

namespace App\Entity;

class BikeStation
{
    public function __construct(
        public readonly string $address,
        public readonly float $latitude,
        public readonly  float $longitude,
        public readonly int $freeBikesCount,
    ) {}
}