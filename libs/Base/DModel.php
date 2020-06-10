<?php

/**
 * @property mixed _dbconfig
 * @author      Obed Ademang <kizit2012@gmail.com>
 * @copyright   Copyright (C), 2015 Obed Ademang
 * @license     MIT LICENSE (https://opensource.org/licenses/MIT)
 *              Refer to the LICENSE file distributed within the package.
 *
 */

namespace DIY\Base;
use DIY\Base\Utils\DUtil;

class DModel {
    protected static $__primaryKey__ = null;
    protected static $__table__ = null;

    public function __construct($table = null, $primaryKey = null){
        if(!is_null($table) && is_string($table)) self::$__table__ = $table;
        if(!is_null($primaryKey) && is_string($primaryKey)) self::$__primaryKey__ = $primaryKey;
    }

    protected static function className(){
        $ref = new \ReflectionClass(get_called_class());
        return $ref->getName();
    }

    public static function find($where, $bindings = array(), $page = 1, $rows = 50){
        if($page < 0) $page = 1;
        $offset = ($page - 1) * $rows;
        $sql = "SELECT * FROM " . self::table() . " WHERE " . $where . " LIMIT " . $offset . ", " . $rows;
        $data = $GLOBALS['db']->select($sql, $bindings);
        $results = array();
        
        foreach($data as $datum) $results[] = DUtil::castToObject($datum, self::className());
        return $results;
    }

    public static function findAll($page = 1, $rows = 50){
        if($page < 0) $page = 1;
        $offset = ($page - 1) * $rows;
        $sql = "SELECT * FROM " . self::table() . " LIMIT " . $offset . ", " . $rows;
        $data = $GLOBALS["db"]->select($sql);
        $results = array();

        foreach($data as $datum) $results[] = DUtil::castToObject($datum, self::className());
        return $results;
    }

    public static function findByPrimaryKey($value){
        $sql = "SELECT * FROM " . self::table() . " WHERE " . self::primary_key() . " = :val";
        $result = $GLOBALS["db"]->select($sql, array("val" => $value));
        if(count($result) === 1) return DUtil::castToObject($result[0], self::className());
    }

    public static function findOne($where, $bindings = array()){
        $sql = "SELECT * FROM " . self::table() . " WHERE " . $where . " LIMIT 1";
        $result = $GLOBALS['db']->select($sql, $bindings);
        if(count($result) === 1) return DUtil::castToObject($result[0], self::className());
    }

    protected static function primary_key($field = null){
        if(self::$__primaryKey__ != null) return self::$__primaryKey__;
        else if(self::$__primaryKey__ == null && $field != null) return self::$__primaryKey__ = $field;
        else return self::$__primaryKey__ = "id";
    }

    public function save(){
        $data = get_object_vars($this);
        $response = $GLOBALS['db']->insertUpdate(self::table(), $data);
        if($response) return true;
        else return false;
    }

    protected static function table($tableName = null){
        if(self::$__table__ != null) return self::$__table__;
        else if(self::$__table__ == null && $tableName != null) return self::$__table__ = $tableName;
        else {
            $reflection = new \ReflectionClass(get_called_class());
            return self::$__table__ = strtolower($reflection->getShortName());
        }
    }
}
