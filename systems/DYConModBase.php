<?php

defined("ACCESS") or define("ACCESS", true);

class DYConModBase
{
    public function db()
    {
        return DYBase::getClass("DYDatabase");
    }

    function helper($class)
    {
        loadClass("helper", $class);
        if (is_array($class)) {
            foreach ($class as $val) {
                $$val = new $val();
                if (!DYBase::getClass($val)) {
                    DYBase::setClass($val, $$val);
                }
            }
        } else {
            $$class = new $class();
            if (!DYBase::getClass($class)) {
                DYBase::setClass($class, $$class);
            }
        }
    }

    function redirect($route, $http_response_code = 302)
    {
        $uri = BASE_URL . "index.php/" . $route;
        header("Location: " . $uri, TRUE, $http_response_code);
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        if ($name == 'db') {
            return DYBase::getClass("DYDatabase");
        }
        echo "你所调用的函数：$name(参数：<br />";
        var_dump($arguments);
        echo ")不存在！";
    }
}