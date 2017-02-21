<?php
/**
 * Created by PhpStorm.
 * User: diligentyang
 * Date: 2017/2/21
 * Time: 19:43
 */

namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class Register
{
    protected static $objects;

    /**
     * 设置别名对象
     *
     * @param $alias 别名
     * @param $object 对象
     */
    static function set($alias, $object)
    {
        if(!isset(self::$objects[$alias])){
            self::$objects[$alias] = $object;
        }
    }

    /**
     * 通过别名获取对象
     *
     * @param $alias 别名
     * @return mixed
     */
    static function get($alias)
    {
        return isset(self::$objects[$alias])?self::$objects[$alias]:false;
    }

    /**
     * @return mixed
     */
    static function getAll()
    {
        return self::$objects;
    }

    /**
     * @param $alias
     */
    function del($alias)
    {
        if(isset(self::$objects[$alias])){
            unset(self::$objects[$alias]);
        }
    }

}