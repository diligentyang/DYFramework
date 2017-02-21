<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class Route{
    public $module;
    public $controller;
    public $method;
    function __construct()
    {

    }

    function getControllerPath()
    {
        $routes = $_SERVER['REQUEST_URI'];
        if (!strpos($routes, "index.php")) {
            $routes .= "index.php";
        }
        $routes = substr($routes, strpos($routes, "index.php") + 10);
        $controllerPath = "";
        $controllerName = "";
        $controllerRoute = "";
        $method = "";
        if ($routes) {
            $str_route1 = "";
            foreach (preg_split("[-]", $routes) as $value) {
                $str_route1 .= ucfirst($value);
            }
            $str_route2 = "";
            foreach (preg_split("[/]", $str_route1) as $value) {
                $str_route2 .= ucfirst($value) . "/";
            }
            $routes = rtrim($str_route2, "/");
            $routesArray = explode("/", $routes);
            $num = count($routesArray);
            foreach ($routesArray as $value) {
                $num--;
                if ($controllerRoute == "") {
                    $controllerRoute = $value;
                } else {
                    $controllerRoute .= "/" . $value;
                }
                $controllerPath = "controllers/" . $controllerRoute . ".php";
                if (!is_file(BASE_PATH . $controllerPath)) {
                    if ($num == 0) {
                        DYBaseFunc::showErrors("Can't find the Controller!");
                    }
                    continue;
                }
                $controllerName = $value;
                break;
            }
        } else {
            $controllerName = DEFAULT_CONTROLLER;
            $controllerRoute = DEFAULT_CONTROLLER;
            $controllerPath = "controllers/" . DEFAULT_CONTROLLER . ".php";
        }
        dd($controllerPath);
        //先默认，控制器没有多级文件夹，不使用strrpos确定的原因是，如果为多级文件，文件名和控制器名字相同，易出现bug
        DYBaseFunc::importFile($controllerPath);
        if (class_exists($controllerName)) {
            if (!DYbase::getClass($controllerName)) {
                DYbase::setClass($controllerName, new $controllerName);
            }
            $controller = DYbase::getClass($controllerName);
            $routes = substr($routes, strlen($controllerRoute) + 1);
            //如果$routes 为false，则说明URL中不含method
            if ($routes) {
                if (strpos($routes, "?")) {
                    $f = strpos($routes, "?");
                    $routes = substr($routes, 0, $f);
                }
                $methodArray = explode("/", $routes);

                if (method_exists($controller, "action" . $methodArray[0])) {
                    $method = "action" . $methodArray[0];
                } else {
                    showErrors("Can't find the method!");
                }
            } else {
                $method = "action" . DEFAULT_METHOD;
            }
            return $controller->$method();
        }

        showErrors("Run the method wrong!");
        return false;
    }
}