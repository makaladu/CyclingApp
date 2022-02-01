<?php

declare(strict_types=1);

namespace App\Application\FileParser\Factory;

use App\Application\FileParser\FileParser;
use App\Application\FileParser\Enum\FileTypes;
use App\Application\FileParser\Exception\FileParserFactoryException;
use App\Application\FileParser\Strategy\CsvParserStrategy;

class FileParserFactory
{
    /**
     * @throws FileParserFactoryException
     */
    public static function createFromFileFormat(FileTypes $fileType): FileParser
    {
        return match ($fileType) {
            FileTypes::CSV => new FileParser(new CsvParserStrategy()),
            default => throw new FileParserFactoryException('Incorrect file type'),
        };
    }
}