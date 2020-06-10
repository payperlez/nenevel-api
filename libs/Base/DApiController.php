<?php

/**
 * @author      Obed Ademang <kizit2012@gmail.com>
 * @copyright   Copyright (C), 2015 Obed Ademang
 * @license     MIT LICENSE (https://opensource.org/licenses/MIT)
 *              Refer to the LICENSE file distributed within the package.
 *
 */

namespace DIY\Base;
use \DIY\Base\Utils\DUtil;

class DApiController extends BaseController {
    public function __construct(){
        parent::__construct();
    }

    public function message($status, $message, $errorCode = null) {
        if($status === false){
            return response()->json([
                "success" => false,
                "data" => $message,
                "error_code" => (!empty($errorCode)) ? $errorCode : "DERRx000"
            ]);
        } else{
            return response()->json([
                "success" => true,
                "data" => $message
            ]);
        }
    }
}