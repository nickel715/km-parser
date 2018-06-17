<?php

namespace App\LogParser;

use App\Entity\AccessLog;
use PHPUnit\Framework\TestCase;

/**
 * @property AccessLogParser sut
 * @property AccessLog       entity
 */
class AccessLogParserTest extends TestCase
{
    const LOG_LINE = '127.0.0.1 - frank [10/Oct/2000:13:55:36 -0700] "GET /apache_pb.gif HTTP/1.0" 200 2326';
    const LOG_LINE_NULL = '127.0.0.1 - - [10/Oct/2000:13:55:36 -0700] "GET /apache_pb.gif HTTP/1.0" 200 -';

    protected function setUp()
    {
        $this->sut = new AccessLogParser();
        $this->entity = new AccessLog();
        $this->entity
            ->setRemoteHost('127.0.0.1')
            ->setClientIdent(null)
            ->setAuthUser('frank')
            ->setTimestamp(new \DateTimeImmutable('2000-10-10T13:55:36-07:00'))
            ->setMethod('GET')
            ->setRequestPath('/apache_pb.gif')
            ->setHttpVersion('HTTP/1.0')
            ->setServerResponse(200)
            ->setResponseSize(2326)
        ;
    }

    public function testParse()
    {
        $this->assertEquals($this->entity, $this->sut->parse(self::LOG_LINE));
    }

    /**
     * @expectedException \App\LogParser\ParseException
     * @expectedExceptionMessage Failed to parse line: foobar
     */
    public function testParseInvalidLine()
    {
        $this->sut->parse('foobar');
    }

    public function testParseWithNullValues()
    {
        $this->entity
            ->setClientIdent(null)
            ->setAuthUser(null)
            ->setResponseSize(0)
        ;
        $this->assertEquals($this->entity, $this->sut->parse(self::LOG_LINE_NULL));
    }
}
