<?php

declare(strict_types=1);

namespace App\Application\FileParser\Strategy;

use App\Application\FileParser\Exception\FileParserException;

interface FileParserStrategyInterface
{
    /**
     * @throws FileParserException
     */
    public function parseToArray(string $filePath): array;
}