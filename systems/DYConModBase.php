<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class DYConModBase
{
    /**
     * Redirect
     *
     * @param string $route uri route
     * @param int $http_response_code code
     *
     * @return null
     */
    function redirect($route, $http_response_code = 302)
    {
        $uri = BASE_URL . "index.php/" . $route;
        header("Location: " . $uri, true, $http_response_code);
    }
	
	/**
	* 获取指定的URL值，比如index.php/admin/index/1/2/3/4
	* segment(1) = admin;
	* segment(2) = index;
	* segment(3) = 1;
	*/
	function segment($a = 3)
    {
        $route = $_SERVER['REQUEST_URI'];
		$route = substr($route,strpos($route,"index.php")+10);
        if (!$route) {
            showErrors("please check your url!");
        }
        $route = explode("/", $route);
        return isset($route[$a - 1])?$route[$a - 1]:false;
    }
	
    /**
     * Encodes special characters into HTML entities.
     *
     * @param  string $content the content to be encoded
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
     * @param string $content the content to be decoded
     *
     * @return string
     */
    public function htmlDecode($content)
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }

    /**
     * Get post data by name
     *
     * @param string $name the name you want to post
     * @param bool|true $decode htmlDecode or not
     *
     * @return string
     */
    public function getPost($name, $decode = true)
    {
        if (isset($_POST[$name])) {
            return $decode ? $this->htmlDecode($name) : $_POST[$name];
        } else {
            showErrors("Don't exist $name please check your data");
        }
    }

    /**
     * Set session with key and value
     *
     * @param string $key The session key
     * @param string $val The value of the session
     *
     * @return bool
     */
    public function setSession($key, $val = "")
    {
        if (isset($key)) {
            $_SESSION[$key] = trim($val);
            return true;
        }
        showErrors("The method setSession need at lest one param!");
        return false;
    }

    /**
     * Get session
     *
     * @param string $key the key of session
     *
     * @return null
     */
    public function getSession($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Set flash session
     *
     * @param string $key the session key
     * @param string $val the session value
     *
     * @return bool
     */
    public function setFlash($key, $val = "")
    {
        if (isset($key)) {
            $_SESSION[$key] = trim($val);
            return true;
        }
        showErrors("The method setFlash need at lest one param!");
        return false;
    }

    /**
     * Get flash session
     *
     * @param string $key the key of flash session
     *
     * @return mixed
     */
    public function getFlash($key)
    {
        if (isset($_SESSION[$key])) {
            $flash = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $flash;
        } else {
            return null;
        }
    }

    /**
     * Magic method
     *
     * @param string $name class name
     * @param mixed $arguments Info
     *
     * @return null|object
     */
    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        echo "你所调用的函数：$name(参数：<br />";
        var_dump($arguments);
        echo ")不存在！";
        return null;
    }
}