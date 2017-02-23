<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class DYController extends DYConModBase
{

    static private $_classes = array();

    /**
     * DYController constructor.
     */
    function __construct()
    {

    }

    /**
     * Include Model
     *
     * @param string $model Model name
     *
     * @return mixed
     */
    public function model($model)
    {
        $ModelPath = BASE_PATH . "models/" . str_replace("/", DS, $model) . ".php";
        if (!is_file($ModelPath)) {
            showErrors("don't find the model!");
        }
        $arr = explode("/", $model);
        $ModelName = $arr[count($arr) - 1];
        include_once "$ModelPath";
        if (!$this->getClass($ModelName)) {
            $this->setClass($ModelName, new $ModelName);
        }
        $ModelClass = $this->getClass($ModelName);
        return $ModelClass;
    }

    /**
     * Include view
     *
     * @param string $viewpath View path
     * @param array  $data     Data
     *
     * @return null
     */
    function view($viewpath, $data = array())
    {
        extract($data);//该函数使用数组键名作为变量名，使用数组键值作为变量值。针对数组中的每个元素，将在当前符号表中创建对应的一个变量。
        $viewpath = trim($viewpath);
        $viewpath = BASE_PATH . "views" . DS . $viewpath;
        if (is_file($viewpath . ".html")) {
            include($viewpath . ".html");
        } else if (is_file($viewpath . ".htm")) {
            include($viewpath . ".htm");
        } else if (is_file($viewpath . ".php")) {
            include($viewpath . ".php");
        } else {
            DYBaseFunc::showErrors("Only .php|.html|.htm can be viewed and please check your view path");
        }
    }

    /**
     * Set class into $_classes
     *
     * @param string $class Model class name
     * @param object $val   Model object
     *
     * @return null
     */
    function setClass($class, $val)
    {
        if (!$this->getClass($class)) {
            self::$_classes[$class] = $val;
        }
    }

    /**
     * Get Class or not
     *
     * @param string $class Class name
     *
     * @return mixed
     */
    function getClass($class)
    {
        return isset(self::$_classes[$class]) ? self::$_classes[$class] : null;
    }

}