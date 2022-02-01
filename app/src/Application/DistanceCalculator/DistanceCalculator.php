<?php

declare(strict_types=1);

namespace App\Application\DistanceCalculator;

class DistanceCalculator
{
    private const EARTH_RADIUS = 6371;

    public function calculateDistanceBetweenPoints(
        float $latitudeA,
        float $longitudeA,
        float $latitudeB,
        float $longitudeB
    ): float {
        $dLat = deg2rad($latitudeB - $latitudeA);
        $dLon = deg2rad($longitudeB - $longitudeA);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitudeA)) * cos(deg2rad($latitudeB)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));

        return self::EARTH_RADIUS * $c;
    }
}