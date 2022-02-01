<?php

declare(strict_types=1);

namespace App\Application\FileParser\Strategy;

use League\Csv\Reader;

class CsvParserStrategy implements FileParserStrategyInterface
{
    public function parseToArray(string $filePath): array
    {
        $csv = Reader::createFromPath($filePath);
        $csv->setHeaderOffset(0);

        return iterator_to_array($csv->getRecords());
    }
}