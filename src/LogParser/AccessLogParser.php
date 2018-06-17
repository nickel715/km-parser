<?php

namespace App\LogParser;

use App\Entity\AccessLog;

class AccessLogParser implements LogParserInterface
{
    const PATTERN = '~^(?P<remote_host>.*?) (?P<client_ident>.*?) (?P<auth_user>.*?) \[(?P<timestamp>.*?)\] \"(?P<method>.*?) (?P<request_path>.*?) (?P<http_version>HTTP/.*)?\" (?P<server_response>.*?) (?P<response_size>.*?)$~';

    public function parse(string $line): AccessLog
    {
        if (!preg_match(self::PATTERN, $line, $matches)) {
            throw new ParseException('Failed to parse line: ' . $line);
        }

        $accessLog = new AccessLog();
        $accessLog->setRemoteHost($matches['remote_host'])
            ->setClientIdent($this->convertNullValues($matches['client_ident']))
            ->setAuthUser($this->convertNullValues($matches['auth_user']))
            ->setTimestamp(new \DateTimeImmutable($matches['timestamp']))
            ->setMethod($matches['method'])
            ->setRequestPath($matches['request_path'])
            ->setHttpVersion($matches['http_version'])
            ->setServerResponse($matches['server_response'])
            ->setResponseSize((int)$this->convertNullValues($matches['response_size']))
        ;

        return $accessLog;
    }

    protected function convertNullValues($value)
    {
        return $value == '-' ? null : $value;
    }
}
