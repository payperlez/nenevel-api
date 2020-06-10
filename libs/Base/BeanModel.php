<?php

namespace DIY\Base;
use \RedBeanPHP\SimpleModel;

class BeanModel extends SimpleModel{
    public static $config = array('table' => '');

    public function __construct($bean = null){
        if(is_null($bean)) $this->bean = \R::dispense(self::getTable());
        elseif(is_int($bean)) $this->bean = \R::load(self::getTable(), $bean);
        else $this->bean = $bean;
    }

    public static function findAll($sql = null, $bindings = array()){
        $results = array();
        $beans = \R::findAll(self::getTable(), $sql, $bindings);
        foreach($beans as $bean) $results[] = new self($bean);
        return $results;
    }

    public static function findOne($sql = null, $bindings = array()){
        return new self(\R::findOne(self::getTable(), $sql, $bindings));
    }

    public function save(){
        \R::store($this->bean);
    }

    public static function getTable(){
        if(empty(static::$config['table'])){
            $reflection = new \ReflectionClass(get_called_class());
            return strtolower($reflection->getShortName());
        }

        return strtolower(static::$config['table']);
    }
}