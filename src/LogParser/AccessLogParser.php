<?php

namespace App\LogParser;

use App\Entity\AccessLog;

class AccessLogParser implements LogParserInterface
{
    const PATTERN = '~^(?P<ip>.*?) (?P<remote_log_name>.*?) (?P<userid>.*?) \[(?P<date>.*?)\] \"(?P<request_method>.*?) (?P<path>.*?) (?P<request_version>HTTP/.*)?\" (?P<status>.*?) (?P<length>.*?)$~';

    public function parse(string $line): AccessLog
    {
        preg_match(self::PATTERN, $line, $matches);
        // TODO check for parser errors

        $accessLog = new AccessLog();
        $accessLog->setRemoteHost($matches['ip'])
            ->setClientIdent($matches['remote_log_name'] == '-' ? null : $matches['remote_log_name'])
            ->setAuthUser($matches['userid'])
            ->setTimestamp(new \DateTimeImmutable($matches['date']))
            ->setMethod($matches['request_method'])
            ->setRequestPath($matches['path'])
            ->setHttpVersion($matches['request_version'])
            ->setServerResponse($matches['status'])
            ->setResponseSize($matches['length'])
        ;

        return $accessLog;
    }
}
