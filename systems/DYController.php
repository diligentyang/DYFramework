<?php

defined("ACCESS") or define("ACCESS", true);

class DYController
{
    function __construct()
    {
        echo "DYController";
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

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        echo "你所调用的函数：$name(参数：<br />";
        var_dump($arguments);
        echo ")不存在！";
    }
}