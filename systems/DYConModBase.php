<?php

defined("ACCESS") or define("ACCESS", true);

class DYConModBase
{
    /**
     * Get DYDatabase
     *
     * @return null|object
     */
    public function db()
    {
        return DYBase::getClass("DYDatabase");
    }

    /**
     * Load hepler class
     *
     * @param string $class class name
     *
     * @return null
     */
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

    /**
     * Redirect
     *
     * @param string $route              uri route
     * @param int    $http_response_code code
     *
     * @return null
     */
    function redirect($route, $http_response_code = 302)
    {
        $uri = BASE_URL . "index.php/" . $route;
        header("Location: " . $uri, true, $http_response_code);
    }

    /**
     * Magic method
     *
     * @param string $name      class name
     * @param mixed  $arguments Info
     *
     * @return null|object
     */
    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        if ($name == 'db') {
            return DYBase::getClass("DYDatabase");
        }
        echo "你所调用的函数：$name(参数：<br />";
        var_dump($arguments);
        echo ")不存在！";
        return null;
    }
}