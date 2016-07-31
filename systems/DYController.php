<?php

defined("ACCESS") or define("ACCESS", true);

class DYController extends DYConModBase
{
    function __construct()
    {

    }

    static private $model = array();

    public function model($model)
    {
        $ModelPath = BASE_PATH . "models/" . str_replace("/", DS, $model) . ".php";
        if (!is_file($ModelPath)) {
            showErrors("don't find the model!");
        }
        $arr = explode("/", $model);
        $ModelName = $arr[count($arr) - 1];
        include_once($ModelPath);
        $ModelClass = new $ModelName();
        return $ModelClass;
    }

    function view($viewpath, $data = array())
    {
        foreach ($data as $key => $value) {
            $$key = isset($data[$key]) ? $value : "";
        }
        $viewpath = trim($viewpath);
        $viewpath = BASE_PATH . "views" . DS . $viewpath;
        if (is_file($viewpath . ".html")) {
            include($viewpath . ".html");
        } else if (is_file($viewpath . ".htm")) {
            include($viewpath . ".htm");
        } else if (is_file($viewpath . ".php")) {
            include($viewpath . ".php");
        } else {
            showErrors("Only .php|.html|.htm can be viewed and please check your view path");
        }
    }

    function setClass($class, $val)
    {
        if (!$this->getClass($class)) {
            self::$classes[$class] = $val;
        }
    }

    function getClass($class)
    {
        return isset(self::$classes[$class]) ? self::$classes[$class] : null;
    }

}