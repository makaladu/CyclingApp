<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\FileParser\Enum\FileTypes;
use App\Application\FileParser\Exception\FileParserException;
use App\Application\FileParser\Exception\FileParserFactoryException;
use App\Application\FileParser\Factory\FileParserFactory;
use App\Entity\Biker;
use Generator;

class BikerService
{
    public function getBikersFromStorage(): Generator
    {
        $filePath = '../src/Infrastructure/Storage/bikers.csv';

        $pathParts = pathinfo($filePath);
        $fileExtension = $pathParts['extension'];

        try {
            $fileParser = FileParserFactory::createFromFileFormat(FileTypes::tryFrom($fileExtension));
            $fileContent = $fileParser->parseToArray($filePath);
        } catch (FileParserFactoryException | FileParserException) {
            //Log exception
            return null;
        }

        foreach ($fileContent as $item) {
            if (!$this->isValidateBikerData($item)) {
                //Maybe introduce validation exception that can be shown to user if needed
                continue;
            }

            yield new Biker(
                (float) $item['latitude'],
                (float) $item['longitude'],
                (int) $item['count'],
            );
        }
    }

    private function isValidateBikerData(array $bikerData): bool
    {
        if (
            !isset($bikerData['latitude']) ||
            !isset($bikerData['longitude']) ||
            !isset($bikerData['count'])
        ) {
            return false;
        }

        return true;
    }
}