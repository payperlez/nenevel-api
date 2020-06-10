<?php
    
namespace DIY\Base;
use Pecee\SimpleRouter\SimpleRouter;

class Router extends SimpleRouter{
    /*
     * @throws \Exception 
     * @throws \Pecee\Http\Middleware\Exceptions\TokenMismatchException
     * @throws \Pecee\SimpleRouter\Exceptions\HttpException
     * @throws \Pecee\SimpleRouter\Exceptions\NotFoundHttpException
     */

    public static function start() : void {
        require_once dirname(dirname(dirname(__FILE__))) . "/libs/helpers.php";
        require_once dirname(dirname(dirname(__FILE__))) . "/app/routes.php";
        parent::start();
    }
}