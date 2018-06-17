<?php

namespace App;

use App\LogParser\LogParserInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LogReaderTest extends TestCase
{
    const TEST_LOG_LINE = 'Test log line';

    public function testReadLog()
    {
        $entity = new \stdClass();

        /** @var LogParserInterface|MockObject $logParser */
        $logParser = $this->createMock(LogParserInterface::class);
        $logParser->expects($this->once())
            ->method('parse')
            ->with(self::TEST_LOG_LINE)
            ->willReturn($entity)
        ;

        $file = new \SplFileObject('php://memory', 'w+');
        $file->fwrite(self::TEST_LOG_LINE);
        $file->rewind();

        $sut = new LogReader($logParser);
        $this->assertSame([$entity], iterator_to_array($sut->readLog($file)));
    }
}
