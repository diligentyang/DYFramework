<?php

defined("ACCESS") or define("ACCESS", true);

class Request
{
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
    }

    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET' ? true : false;
    }

    public function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function post($name, $xss = true){
        $name = $_POST[$name];
        return $xss===true?htmlspecialchars($name) : $name;
    }

    public function get($name, $xss = true){
        $name = $_GET[$name];
        return $xss===true?htmlspecialchars($name) : $name;
    }
}
