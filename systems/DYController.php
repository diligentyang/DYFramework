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
}