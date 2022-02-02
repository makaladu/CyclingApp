<?php

require './../vendor/autoload.php';

ini_set('display_errors', 0);
ini_set('log_errors', 1);

$cityBikeController = new \App\UserInterface\CityBikeController();

try {
    $cityBikeController->getClosestStationsForBikersAction();
} catch (Exception $e) {
    //Implement logger
    echo('Could not handle request');
}
