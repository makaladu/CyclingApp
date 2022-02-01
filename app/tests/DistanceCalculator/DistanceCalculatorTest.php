<?php

declare(strict_types=1);

namespace Tests\DistanceCalculator;

use App\Application\DistanceCalculator\DistanceCalculator;
use PHPUnit\Framework\TestCase;

class DistanceCalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCalculateDistanceBetweenPoints(
        array $pointACoordinates,
        array $pointBCoordinates,
        float $expectedDistanceCalculationResult
    ): void {
        $distanceCalculator = new DistanceCalculator();

        $distance = $distanceCalculator->calculateDistanceBetweenPoints(
            $pointACoordinates['latitude'],
            $pointACoordinates['longitude'],
            $pointBCoordinates['latitude'],
            $pointBCoordinates['longitude'],
        );

        $this->assertEquals($expectedDistanceCalculationResult, $distance);
    }

    public function dataProvider(): array
    {
        return [
            [
                'pointACoordinates' => [
                    'latitude' => 55.67766,
                    'longitude' => 12.59747,
                ],
                'pointBCoordinates' => [
                    'latitude' => 55.68766,
                    'longitude' => 12.69747,
                ],
                'expectedDistanceCalculationResult' => 6.3667554012167
            ],
            [
                'pointACoordinates' => [
                    'latitude' => 55.68186,
                    'longitude' => 12.56989,
                ],
                'pointBCoordinates' => [
                    'latitude' => 55.69766,
                    'longitude' => 12.68747,
                ],
                'expectedDistanceCalculationResult' => 7.5761588634049
            ],
        ];
    }
}