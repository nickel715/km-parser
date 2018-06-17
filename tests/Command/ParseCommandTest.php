<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ParseCommandTest extends KernelTestCase
{
    const TEST_LOG_LINE = '127.0.0.1 - frank [10/Oct/2000:13:55:36 -0700] "GET /apache_pb.gif HTTP/1.0" 200 2326';

    public function testExecute()
    {
        $this->markTestIncomplete('TODO figure out how to mock db and then finish test');
        $kernel = static::createKernel();
        $kernel->boot();
        $application = new Application($kernel);
        /** @var ParseCommand $command */
        $command = $application->find('parse');

        $file = new \SplFileObject('php://memory', 'w+');
        $file->fwrite(self::TEST_LOG_LINE);
        $file->rewind();
        $command->setInputFile($file);

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
        ));
    }
}
