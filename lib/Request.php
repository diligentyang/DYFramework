<?php
namespace lib;

defined('ACCESS') OR exit('No direct script access allowed');

class Request
{
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
    }

    public static  function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET' ? true : false;
    }

    public static function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return true;
        } else {
            return false;
        }
    }

    public static function post($name, $xss = true){
        $name = $_POST[$name];
        return $xss===true?htmlspecialchars($name) : $name;
    }

    public static function get($name, $xss = true){
        $name = $_GET[$name];
        return $xss===true?htmlspecialchars($name) : $name;
    }

    public static function getToken()
    {
        return substr(md5(uniqid(mt_rand(), true)),0,10);
    }
}
