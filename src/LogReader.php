<?php

namespace App;

use App\LogParser\LogParserInterface;

/**
 * @property LogParserInterface logParser
 */
class LogReader
{
    public function __construct(LogParserInterface $logParser)
    {
        $this->logParser = $logParser;
    }

    public function readLog(\SplFileObject $file): \Generator
    {
        while (!$file->eof()) {
            yield $this->logParser->parse($file->fgets());
        }
    }
}
