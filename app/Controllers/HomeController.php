<?php

namespace App\Controllers;

use DIY\Base\DApiController;

class HomeController extends DApiController {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->message(true, ["message" => "Hello World!"]);
    }
}
