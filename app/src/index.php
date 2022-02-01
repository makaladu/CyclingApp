<?php

require './../vendor/autoload.php';

$errorLog = '/tmp/php-error.log';
ini_set('display_errors', 'Off');
ini_set('log_errors', 1);
ini_set('error_log', $errorLog);

$cityBikeController = new \App\UserInterface\CityBikeController();

try {
    $cityBikeController->getClosestStationsForBikersAction();
} catch (Exception $e) {
    error_log($e->getMessage());
    error_log($e->getFile());
    error_log($e->getTraceAsString());

    echo('Could not handle request');
}
