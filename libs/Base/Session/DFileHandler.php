<?php

/**
 * @author		Obed Ademang <kizit2012@gmail.com>
 * @copyright	Copyright (C), 2015 Obed Ademang
 * @license		MIT LICENSE (https://opensource.org/licenses/MIT)
 * 				Refer to the LICENSE file distributed within the package.
 *
 *
 * @category	Session
 *
 */

namespace DIY\Base\Session;
use DIY\Base\Utils\DUtil;

class DFileHandler extends \SessionHandler {
    private $key;

    public function __construct($key){
        $this->key = $key;
    }

    public function read($id){
        $data = parent::read($id);
        if(!$data) return "";
        else DUtil::decrypt($data, $this->key);
    }

    public function write($id, $data){
        $data = DUtil::encrypt($data, $this->key);
        return parent::write($id, $data);
    }
}