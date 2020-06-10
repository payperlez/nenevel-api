<?php

namespace DIY\Base;

use DIY\Base\Utils\DRand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DConsole extends Command {

    public function __construct(){
        parent::__construct();
    }

    protected function appConfig(InputInterface $input, OutputInterface $output){
        $io = new SymfonyStyle($input, $output);

        $io->title("Application Configuration!");

        $io->section("Creating .env file: ");
        $envfile = fopen("config/.env", 'w');

        if($envfile !== FALSE){
            $io->success("File successfully created");

            $io->section("Generating secret key: ");
            $secret_key = DRand::getCustomGen(str_split("!#$%&()*+,-./0123456789:;<>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~"), 64);
            (fwrite($envfile, "SECRET_KEY = {$secret_key}\n") !== FALSE) ? $io->success("Secret key written to file!") : $io->error("Error encountered!");

            $io->section("Database configuration: ");
            $useDB = $io->confirm("Are you going to use a database? ");
            if($useDB){
                $scheme = $io->choice("Enter database engine are you using: ", ["mysql", "postgresql"], "mysql");
                $default_port = ($scheme === "mysql") ? "3306" : "5432";
                $user = $io->ask("Enter username for your specified database engine: ", "root");
                $password = $io->askHidden("Enter the password for the user (Text would not show up on terminal): ");
                $host = $io->ask("Enter host on which database engine is located: ", "127.0.0.1");
                $port = $io->ask("Enter port the database engine communicate on: ", $default_port);
                $dbname = $io->ask("Enter database name: ");

                $database_uri = trim($scheme) . "://";
                $database_uri .= trim($user) . ":";
                $database_uri .= $password . "@";
                $database_uri .= trim($host) . ":";
                $database_uri .= trim($port);
                $database_uri .= "/" . trim($dbname);
                fwrite($envfile, "DATABASE_URL = " . trim($database_uri) . "\n") !== FALSE ? $io->success("Database uri written to file!") : $io->error("Error encountered!");
            } else {
                fwrite($envfile, "DATABASE_URL = " . "\n");
                $io->note("If you are not using any database, make sure you comment out the 'DATABASE' constant in config/settings.php!");
            }

            $io->section("Session configuration: ");
            $session_store = $io->choice("What session store will you want to use: ", ["files", "redis"], "files");
            if(trim($session_store) === 'redis'){
                $rhost = $io->ask("What is the redis host: ", "127.0.0.1");
                $rport = $io->ask("What is the redis port: ", "6379");
                $rdb = $io->ask("What is the redis database: ");
        
                $redis_uri = "tcp://" . trim($rhost) . ":" . trim($rport) . "?database=" . trim($rdb);
                fwrite($envfile, "REDIS_URI = " . trim($redis_uri) . "\n") !== FALSE ? $io->success("Redis uri written to file!") : $io->error("Error encountered!");
            }

            fwrite($envfile, "SESSION_STORE = " . trim($session_store) . "\n") !== FALSE ? $io->success("Successful!") : $io->error("Error encountered!");

            $io->section("Miscellaneous configuration: ");
            $domain = $io->ask("Enter domain name for your project / host part of your project's url: ");
            fwrite($envfile, "DOMAIN = " . trim($domain) . "\n") !== FALSE ? $io->success("Domain name written to file!") : $io->error("Error encountered!");

            $env = $io->choice("What environment are you running on: ", ["dev", "prod"], "dev");
            fwrite($envfile, "RUNTIME_ENVIRONMENT = " . trim($env)) !== FALSE ? $io->success("Success!") : $io->error("Error encountered!");
            
            fclose($envfile);

            $io->section("Creating a copy of settings.php file: ");
            if(!copy("config/settings.sample.php", "config/settings.php")){
                $io->warning("Make sure you manually make a copy of 'config/settings.sample.php'");
            } else{
                $io->success("Successfully created settings.php file!");
            }

            $io->note([
                "Check config/.env and make sure that the configuration setup is correct.",
                "Cheers to development..."
            ]);
        } else{
            $io->error("Unable to create .env file");
        }
    }
}