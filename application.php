<?php

use Intelligent\SettingBundle\Cmd\ImportCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;

// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

set_time_limit(0);

/** @var \Composer\Autoload\ClassLoader $loader */
#$loader = require __DIR__.'/autoload.php';
require __DIR__.'/vendor/autoload.php';
$input = new ArgvInput();
$env = $input->getParameterOption(array('--env', '-e'), getenv('SYMFONY_ENV') ?: 'dev');
$debug = getenv('SYMFONY_DEBUG') !== '0' && !$input->hasParameterOption(array('--no-debug', '')) && $env !== 'prod';

if ($debug) {
    Debug::enable();
}
        ini_set('memory_limit','2G');
        ini_set('max_execution_time', 0);
$kernel = new AppKernel($env, $debug);
$application = new Application($kernel);
$application->add(new ImportCommand());
$application->run($input);
