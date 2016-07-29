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
    //生成哈希密码
    public function generatePasswordHash($password, $cost = 12)
    {
        if (function_exists('password_hash')) {
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
        }

        $salt = $this->generateSalt($cost);
        $hash = crypt($password, $salt);
        if (!is_string($hash) || strlen($hash) !== 60) {
            showErrors('Unknown error occurred while generating hash.');
        }

        return $hash;
    }

    public function generateSalt($cost)
    {
        $cost = (int) $cost;
        if ($cost < 4 || $cost > 31) {
            showErrors('Cost must be between 4 and 31.');
        }
        // Get a 20-byte random string
        $rand = $this->generateRandomKey(20);
        // Form the prefix that specifies Blowfish (bcrypt) algorithm and cost parameter.
        $salt = sprintf("$2y$%02d$", $cost);
        // Append the random salt data in the required base64 format.
        $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));

        return $salt;
    }

    public function generateRandomKey($length){
        if (!is_int($length)) {
            showErrors('First parameter ($length) must be an integer');
        }

        if ($length < 1) {
            showErrors('First parameter ($length) must be greater than 0');
        }

        // always use random_bytes() if it is available
        if (function_exists('random_bytes')) {
            return random_bytes($length);
        }
        if (function_exists('mcrypt_create_iv')) {
            $key = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if (mb_strlen($key, '8bit') === $length) {
                return $key;
            }
        }
        showErrors("Unable to generateRandomKey!");
    }

    //check 哈希密码
    public function validatePassword($password, $hash)
    {
        if (!is_string($password) || $password === '') {
            showErrors('Password must be a string and cannot be empty.');
        }
        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            showErrors('Hash is invalid.');
        }

        if (function_exists("password_verify")) {
            return password_verify($password, $hash);
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

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        echo "你所调用的函数：$name(参数：<br />";
        var_dump($arguments);
        echo ")不存在！";
    }

}