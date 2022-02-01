<?php

declare(strict_types=1);

namespace App\UserInterface;

use App\Application\ApiClient\Exception\InvalidApiResponse;
use App\Application\BikerService;
use App\Application\CityBikeService;
use App\Application\FileParser\Exception\FileParserFactoryException;

class CityBikeController
{
    private const NETWORK = 'bycyklen';

    public function execute(): void
    {
        // Missing dependency injection container
        $bikerSrv = new BikerService();
        $cityBikeService = new CityBikeService();

        $bikers = $bikerSrv->getBikersFromStorage();

        if (!$bikers->valid()) {
            echo(json_encode('Could not fetch bikers'));
        }

        foreach ($bikers as $biker) {
           $bikerClosesStationDto = $cityBikeService->findClosestStationForBiker($biker, self::NETWORK);

           if (!$bikerClosesStationDto) {
               echo(json_encode('Could not find closest station'));
           }

           echo($bikerClosesStationDto->toString());
        }
    }
}