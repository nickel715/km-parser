<?php

namespace App\LogParser;

use App\Entity\AccessLog;
use PHPUnit\Framework\TestCase;

class AccessLogParserTest extends TestCase
{
    const LOG_LINE = '127.0.0.1 - frank [10/Oct/2000:13:55:36 -0700] "GET /apache_pb.gif HTTP/1.0" 200 2326';

    public function testParse()
    {
        $sut = new AccessLogParser();
        $actual = $sut->parse(self::LOG_LINE);

        $expected = new AccessLog();
        $expected->setRemoteHost('127.0.0.1')
            ->setClientIdent(null)
            ->setAuthUser('frank')
            ->setTimestamp(new \DateTimeImmutable('2000-10-10T13:55:36-07:00'))
            ->setMethod('GET')
            ->setRequestPath('/apache_pb.gif')
            ->setHttpVersion('HTTP/1.0')
            ->setServerResponse(200)
            ->setResponseSize(2326)
        ;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \App\LogParser\ParseException
     * @expectedExceptionMessage Failed to parse line: foobar
     */
    public function testParseInvalidLine()
    {
        (new AccessLogParser())->parse('foobar');
    }
}
