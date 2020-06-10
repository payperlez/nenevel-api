<?php

/**
 * @author		Obed Ademang <kizit2012@gmail.com>
 * @copyright	Copyright (C), 2015 Obed Ademang
 * @license		MIT LICENSE (https://opensource.org/licenses/MIT)
 * 				Refer to the LICENSE file distributed within the package.
 *
 *
 * @category	Console
 *
*/

namespace DIY\Base\Console;

use DIY\Base\DConsole;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppConfigCommand extends DConsole {
    public function configure(){
        $this->setName('app:config')
            ->setDescription("Configure the application!")
            ->setHelp("This command must be run immediately a project a created to help bootstrap the application!");
    }

    public function execute(InputInterface $input, OutputInterface $output){
        $this->appConfig($input, $output);
        return 0;
    }
}