<?php

declare(strict_types=1);

const APP_DIR = __DIR__;
const SYSTEM_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'src';
const CLASS_EXT = '.php';
const DS = DIRECTORY_SEPARATOR;

require_once SYSTEM_DIR . DS . 'Autoloader'.CLASS_EXT;

Autoloader::init();

$loader = new \App\Loader();
$writer = new \App\Writer();
$output = new \App\Output();

$dispatcher = new \App\Dispatcher($loader, $writer, $output);
$dispatcher->loadConfigFile(APP_DIR . DS .'vstup.txt');
echo $dispatcher->run();