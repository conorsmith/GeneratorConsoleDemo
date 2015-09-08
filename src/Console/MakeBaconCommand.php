<?php

namespace ConorSmith\GeneratorConsoleDemo\Console;

use ConorSmith\GeneratorConsoleDemo\MakeBacon;
use ConorSmith\GeneratorConsoleDemo\Payload;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeBaconCommand extends Command
{
    const EXIT_SUCCESS = 0;
    const EXIT_FAILURE = 1;

    private $domainService;

    public function __construct(MakeBacon $domainService)
    {
        $this->domainService = $domainService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName("bacon:make")
            ->addArgument(
                "portion",
                InputArgument::REQUIRED
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->domainService->call($input->getArgument("portion")) as $payload) {
            $output->writeln($payload->getMessage());

            if ($payload->getStatus() === Payload::FAILURE) {
                return self::EXIT_FAILURE;
            }
        }

        return $payload->getStatus() === Payload::SUCCESS ? self::EXIT_SUCCESS : self::EXIT_FAILURE;
    }
}
