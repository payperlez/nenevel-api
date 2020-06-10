<?php

/**
 * This file is used to mainly bootstrap easy to use console commands to help you bootstrap your application.
 * You could however register your own custom console commands relative to your application.
 * As it is the theme of the whole framework, you are on your own figuring out where what should be and following your own intuine logic. 
*/

require_once 'vendor/autoload.php';

use DIY\Base\Console\AppConfigCommand;
use Symfony\Component\Console\Application as ConsoleApp;

$console = new ConsoleApp();
$console->add(new AppConfigCommand());
$console->run();