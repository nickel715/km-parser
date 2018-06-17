<?php

namespace App\LogParser;

interface LogParserInterface
{
    public function parse(string $line);
}
