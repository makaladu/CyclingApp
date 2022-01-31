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

        try {
            $bikers = $bikerSrv->getBikersFromStorage();
        } catch (FileParserFactoryException $e) {
            echo json_encode($e->getMessage());

            return;
        }

        try {
            foreach ($bikers as $biker) {
               echo (json_encode($cityBikeService->findClosestStationForBiker($biker, self::NETWORK)));
            }
        } catch (InvalidApiResponse $e) {
            echo json_encode($e->getMessage());

            return;
        }
    }
}