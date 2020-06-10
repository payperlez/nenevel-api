<?php

/**
 * @author      Obed Ademang <kizit2012@gmail.com>
 * @copyright   Copyright (C), 2015 Obed Ademang
 * @license     MIT LICENSE (https://opensource.org/licenses/MIT)
 *              Refer to the LICENSE file distributed within the package.
 *
 */

require_once 'vendor/autoload.php';
require_once 'config/settings.php';

use \Whoops\Run as Whoops;
use \Whoops\Handler\JsonResponseHandler;
use \Whoops\Handler\CallbackHandler as DErrorHandler;
use DIY\Base\Bootstrap as Application;

$oops = new Whoops();
if (RUNTIME_ENVIRONMENT === 'dev') {
    $handler = new JsonResponseHandler();
    $handler->setJsonApi(true);
} else {
    $handler = new DErrorHandler(function ($error) {
        file_put_contents("logs/app_error.log", gmdate("d.m.Y h:i:s") . ": " . $error->getMessage() . " File: " . $error->getFile() . " Line: " . $error->getLine() . PHP_EOL, FILE_APPEND | LOCK_EX);
        response()->json(["message" => "An error occured and we have captured it. Please try again shortly!"]);
    });
}

$oops->pushHandler($handler);
$oops->register();

$app = new Application();
$GLOBALS['db'] = $app::$db;
$app::init();