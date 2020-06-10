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
use Predis\Client as PredisClient;
use DIY\Base\Utils\DUtil;

class DRedisHandler implements \SessionHandlerInterface {
    public $ttl = 1800;
    protected $db;
    protected $prefix;
    private $key;
    
    public function __construct(PredisClient $redis, $key, $prefix = 'PHPSESSID:'){
        $this->db = $redis;
        $this->prefix = $prefix;
        $this->key = $key;
    }

    public function open($savePath, $sessionName){
        return true;
    }

    public function close(){
        $this->db = null;
        unset($this->db);
        return true;
    }

    public function read($id){
        $id = $this->prefix . $id;
        $sessData = $this->db->get($id);
        if(!$sessData) return "";
        else {
            $this->db->expire($id, $this->ttl);
            return DUtil::decrypt($sessData, $this->key);
        }
    }

    public function write($id, $data){
        $id = $this->prefix . $id;
        $data = DUtil::encrypt($data, $this->key);
        $this->db->set($id, $data);
        $this->db->expire($id, $this->ttl);
        return true;
    }

    public function destroy($id){
        $this->db->del($this->prefix . $id);
    }

    public function gc($maxLifetime){
        return true;
    }
}