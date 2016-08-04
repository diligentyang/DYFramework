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
     * Encodes special characters into HTML entities.
     *
     * @param  string    $content      the content to be encoded
     * @param  bool|true $doubleEncode boolean $doubleEncode whether to encode HTML entities in `$content`. If false,
     * HTML entities in `$content` will not be further encoded.
     *
     * @return string
     */
    public function htmlEncode($content, $doubleEncode = true)
    {
        return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
    }

    /**
     * Decode HTML entities
     *
     * @param $content string the content to be decoded
     *
     * @return string
     */
    public function htmlDecode($content)
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }

    /**
     * Get base url
     *
     * @return string
     */
    public function base_url()
    {
        return BASE_URL;
    }


    public function site_url()
    {

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