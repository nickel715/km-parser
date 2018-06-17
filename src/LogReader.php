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
            $line = trim($file->fgets());
            if (!empty($line)) {
                yield $this->logParser->parse($line);
            }
        }
    }
}
