<?php

namespace App\Command;

use App\LogReader;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property LogReader       logReader
 * @property ManagerRegistry managerRegistry
 * @property \SplFileObject  inputFile
 */
class ParseCommand extends Command
{
    protected static $defaultName = 'parse';

    public function __construct(LogReader $logReader, ManagerRegistry $managerRegistry)
    {
        $this->logReader = $logReader;
        $this->managerRegistry = $managerRegistry;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Reads logfile from STDIN and parse it');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->managerRegistry->getManager();

        foreach ($this->logReader->readLog($this->getInputFile()) as $entity) {
            try {
                $entityManager->persist($entity);
                $entityManager->flush(); // Flush after every row because the input can be a stream
            } catch (ORMException $e) {
                $errorOutput = $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output;
                $errorOutput->write('Failed to persist row: ');
                $errorOutput->writeln(print_r($entity));
            }
        }
    }

    public function setInputFile(\SplFileObject $fileObject)
    {
        $this->inputFile = $fileObject;
        return $this;
    }

    public function getInputFile()
    {
        empty($this->inputFile) && $this->inputFile = new \SplFileObject('php://stdin');
        return $this->inputFile;
    }
}
