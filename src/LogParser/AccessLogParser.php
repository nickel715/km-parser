<?php

namespace App\LogParser;

use App\Entity\AccessLog;

class AccessLogParser implements LogParserInterface
{
    const PATTERN = '~^(?P<ip>.*?) (?P<remote_log_name>.*?) (?P<userid>.*?) \[(?P<date>.*?)\] \"(?P<request_method>.*?) (?P<path>.*?) (?P<request_version>HTTP/.*)?\" (?P<status>.*?) (?P<length>.*?)$~';

    public function parse(string $line): AccessLog
    {
        if (!preg_match(self::PATTERN, $line, $matches)) {
            throw new ParseException('Failed to parse line: ' . $line);
        }

        $accessLog = new AccessLog();
        $accessLog->setRemoteHost($matches['ip'])
            ->setClientIdent($this->convertNullValues($matches['remote_log_name']))
            ->setAuthUser($this->convertNullValues($matches['userid']))
            ->setTimestamp(new \DateTimeImmutable($matches['date']))
            ->setMethod($matches['request_method'])
            ->setRequestPath($matches['path'])
            ->setHttpVersion($matches['request_version'])
            ->setServerResponse($matches['status'])
            ->setResponseSize((int)$this->convertNullValues($matches['length']))
        ;

        return $accessLog;
    }

    protected function convertNullValues($value)
    {
        return $value == '-' ? null : $value;
    }
}
