<?php

declare(strict_types=1);

namespace App\UserInterface;

use App\Application\BikerService;
use App\Application\CityBikeService;

class CityBikeController
{
    private const NETWORK = 'bycyklen';

    public function getClosestStationsForBikersAction(): void
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

               continue;
           }

           echo($bikerClosesStationDto->toString());
        }
    }
}