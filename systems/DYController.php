<?php

defined("ACCESS") or define("ACCESS", true);

class DYController
{
    function __construct()
    {

    }

    static private $model = array();

    public function model($model)
    {
        $ModelPath = BASE_PATH."models/".str_replace("/",DS,$model).".php";
        if(!is_file($ModelPath)){
            showErrors("don't find the model!");
        }
        $arr = explode("/",$model);
        $ModelName = $arr[count($arr)-1];
        include_once($ModelPath);
        $ModelClass = new $ModelName();
        return $ModelClass;
    }

    public function db()
    {
        return new DYDatabase();
    }

    function helper($class = array())
    {
        loadClass("helper",$class);
    }

    function library($class = array())
    {
        loadClass("library",$class);
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        echo "你所调用的函数：$name(参数：<br />";
        var_dump($arguments);
        echo ")不存在！";
    }

}