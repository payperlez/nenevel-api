<?php

/**
 * @author      Obed Ademang <kizit2012@gmail.com>
 * @copyright   Copyright (C), 2015 Obed Ademang
 * @license     MIT LICENSE (https://opensource.org/licenses/MIT)
 *              Refer to the LICENSE file distributed within the package.
 */

namespace DIY\Base;

class Bootstrap {
    private static $_db_config = array();
    public static $db = null;

    public function __construct(){
        static::$_db_config = unserialize(DATABASE);
        if (USE_ORM) {
            $dsn = static::$_db_config['type'] . ":host=" . static::$_db_config['host'] . ";dbname=" .          
                    static::$_db_config['name'];
            \R::setup($dsn, static::$_db_config['user'], static::$_db_config['passwd']);
        } else static::$db = new Database(static::$_db_config);
    }

    public static function init(){
        Router::start();
    }
}