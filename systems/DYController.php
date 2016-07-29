<?php

defined("ACCESS") or define("ACCESS", true);

class DYController
{
    static private $classes;

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

    public function db()
    {
        return new DYDatabase();
    }

    function helper($class)
    {
        loadClass("helper", $class);
        if (is_array($class)) {
            foreach ($class as $val) {
                $$val = new $val();
                if (!$this->getClass($val)) {
                    $this->setClass($val, $$val);
                }
            }
        } else {
            $$class = new $class();
            if (!$this->getClass($class)) {
                $this->setClass($class, $$class);
            }
        }
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

    function redirect($route, $http_response_code = 302)
    {
        $uri = BASE_URL . "index.php/" . $route;
        header("Location: " . $uri, TRUE, $http_response_code);
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

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        echo "你所调用的函数：$name(参数：<br />";
        var_dump($arguments);
        echo ")不存在！";
    }

}