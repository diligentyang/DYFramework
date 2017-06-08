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

    public static function post($name = null, $xss = true){
        if($name){
            $name = $_POST[$name];
            return $xss===true?htmlspecialchars($name) : $name;
        }else{
            return $_POST;
        }

    }

    public static function get($name = null, $xss = true){
        if($name){
            $name = $_GET[$name];
            return $xss===true?htmlspecialchars($name) : $name;
        }else{
            return $_GET;
        }

    }

    public static function getToken()
    {
        return substr(md5(uniqid(mt_rand(), true)),0,10);
    }

    //获取客户端ip
    public static function ip($type = 0)
    {
        $type = intval($type);
        //保存客户端IP地址
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } else if (isset($_SERVER["REMOTE_ADDR"])) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                return '';
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } else if (getenv("REMOTE_ADDR")) {
                $ip = getenv("REMOTE_ADDR");
            } else {
                return '';
            }
        }
        $long     = ip2long($ip);
        $clientIp = $long ? [$ip, $long] : ["0.0.0.0", 0];
        return $clientIp[$type];
    }

}
