<?php

namespace App;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// #[AsCommand(name: 'demo:args', description: 'Describe args behaviors')]

class CsvToJsonCommand extends Command{
    public static function getDefaultName(): ?string
    {
        return 'csv-to-json';
    }
    protected function configure(): void
    {
        
        $this
            ->setDefinition(
                new InputDefinition([
                    new InputOption('input', 'i', InputOption::VALUE_REQUIRED,'Input file name'),
                    new InputOption('output', 'o', InputOption::VALUE_REQUIRED,'Output file name'),
                ])
            );
            // ->setDefinition(
            //     new InputDefinition([
            //         new InputOption('foo', 'f'),
            //         new InputOption('bar', 'b', InputOption::VALUE_REQUIRED),
            //         new InputOption('cat', 'c', InputOption::VALUE_OPTIONAL),
            //     ])
            // );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFileName = $input->getOption('input');
        $outputFileName = $input->getOption('output');

        if(!file_exists($inputFileName)){
            $output->writeln('<error>File not Found</error>');
            return Command::FAILURE;
        }

        $items = array_map('str_getcsv',file($inputFileName));
        
        $header = array_shift($items);
        $jsonContent = [];

        foreach($items as $item){
            $jsonContent []= array_combine($header,$item);
        }
       file_put_contents($outputFileName,json_encode($jsonContent,JSON_PRETTY_PRINT));
       $output->writeln('<info>File successfully created</info>');
       return Command::SUCCESS;

    }

}