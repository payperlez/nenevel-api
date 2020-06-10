<?php

/**
 * @property Gump $validate
 * @author      Obed Ademang <kizit2012@gmail.com>
 * @copyright   Copyright (C), 2015 Obed Ademang
 * @license     MIT LICENSE (https://opensource.org/licenses/MIT)
 *              Refer to the LICENSE file distributed within the package.
 *
 */

namespace DIY\Base;
use \DIY\Base\Utils\Session;

class BaseController {
    public $validate;

    public function __construct(){
        Session::init();
        $this->validate = new \GUMP();   
    }
}