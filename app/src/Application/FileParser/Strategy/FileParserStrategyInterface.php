<?php

declare(strict_types=1);

namespace App\Application\FileParser\Strategy;

interface FileParserStrategyInterface
{
    public function parseToArray(string $filePath): array;
}