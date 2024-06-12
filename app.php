#!/usr/bin/env php
<?php
// application.php
//https://symfony.com/doc/current/components/console/console_arguments.html
require __DIR__.'/vendor/autoload.php';

use App\CsvToJsonCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new CsvToJsonCommand());

$application->run();
