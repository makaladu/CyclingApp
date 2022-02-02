<?php

declare(strict_types=1);

namespace App\Application\FileParser;

use App\Application\FileParser\Exception\FileParserException;
use App\Application\FileParser\Strategy\FileParserStrategyInterface;

class FileParser
{
    public function __construct(
        private FileParserStrategyInterface $strategy,
    ) {}

    /**
     * @throws FileParserException
     */
    public function parseToArray(string $file): array
    {
        return $this->strategy->parseToArray($file);
    }
}