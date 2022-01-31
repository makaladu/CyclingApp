<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\FileParser\Enum\FileTypes;
use App\Application\FileParser\Exception\FileParserFactoryException;
use App\Application\FileParser\Factory\FileParserFactory;
use App\Entity\Biker;
use Generator;

class BikerService
{
    /**
     * @throws FileParserFactoryException
     */
    public function getBikersFromStorage(): Generator
    {
        $filePath = '../src/Infrastructure/Storage/bikers.csv';

        $pathParts = pathinfo($filePath);
        $fileExtension = $pathParts['extension'];

        $fileParser = FileParserFactory::createFromFileFormat(FileTypes::tryFrom($fileExtension));
        $fileContent = $fileParser->parseToArray($filePath);

        foreach ($fileContent as $item) {
            yield new Biker(
                (float) $item['latitude'],
                (float) $item['longitude'],
                (int) $item['count'],
            );
        }
    }
}