<?php

declare(strict_types=1);

namespace App\Application\FileParser\Strategy;

use App\Application\FileParser\Exception\FileParserException;
use League\Csv\Exception;
use League\Csv\Reader;

class CsvParserStrategy implements FileParserStrategyInterface
{
    /**
     * @throws FileParserException
     */
    public function parseToArray(string $filePath): array
    {
        try {
            $csv = Reader::createFromPath($filePath);
            $csv->setHeaderOffset(0);
        } catch (Exception) {
            throw new FileParserException('Could not parse file');
        }

        return iterator_to_array($csv->getRecords());
    }
}