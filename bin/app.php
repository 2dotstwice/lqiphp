#!/usr/bin/env php
<?php

use TwoDotsTwice\LQIPHP\ConsoleCommand\PrimitiveConsoleCommand;

require_once __DIR__ . '/../vendor/autoload.php';

$consoleApp = new \Symfony\Component\Console\Application();

$consoleApp->add(new PrimitiveConsoleCommand());

$consoleApp->run();
