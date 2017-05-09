<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class Route{
    public $controller;
    public $method;
    function __construct()
    {
        $routes = $this->GetFormatUrl();
        $this->controller = $this->GetController($routes);
        $this->method = $this->GetMethod($routes, $this->controller);
    }

    /**
     * 获取格式化的路由，包括控制器+方法+参数
     *
     * @return string
     */
    private function GetFormatUrl()
    {
        $routes = $_SERVER['REQUEST_URI'];
        if (!strpos($routes, "index.php")) {
            $routes .= "index.php";
        }
        $routes = substr($routes, strpos($routes, "index.php") + 10);
        if ($routes) {
            $str_route1 = "";
            foreach (preg_split("[-]", $routes) as $value) {
                $str_route1 .= ucfirst($value);
            }
            $str_route2 = "";
            foreach (preg_split("[/]", $str_route1) as $value) {
                $str_route2 .= ucfirst($value) . "/";
            }
            return rtrim($str_route2,'/');
        }else{
            $config = \systems\Factory::GetConfig();
            return ucfirst($config['Config']['defalut_controller']).'/'.ucfirst($config['Config']['defalut_method']);
        }
    }

    /**
     * 获取控制器的名称包括包含其的文件夹。
     *
     * @param $routes
     * @return string
     */
    private function GetController($routes)
    {
        $controllerRoute = "";
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
        return $controllerRoute;
    }

    /**
     * 获取控制器中的方法名称 action
     *
     * @param $routes 格式化后的路由
     * @param $controllerName 控制器名字
     * @return string
     */
    private function GetMethod($routes,$controllerName)
    {
        $action = substr($routes,strlen($controllerName));
        if($action){
			if($action[0] == "/"){
				$action = substr($action,1);
			}
            return substr($action,0,strpos($action,"/"));
        }else{
			$config = \systems\Factory::GetConfig();
            return ucfirst($config['Config']['defalut_method']);
        }
    }
}