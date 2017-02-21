<?php
namespace systems;
defined("ACCESS") or define("ACCESS", true);

class DYApp
{

    /**
     * Start app
     *
     * @return null
     */
    public function start()
    {
        if (AUTO_START_SESSION) {
            if (!session_id()) {
                session_start();
            }
        }

        $this->runController();
    }

    /**
     * 不支持控制器多级目录
     */
    /*    public function runController()
        {
            $routes = getRouteAll();
            $controllerName="";
            if($routes){
                $routesArray = explode("/",$routes);
                $num = count($routesArray);
                foreach($routesArray as $value){
                    $num--;
                    $controllerPath = "controllers/".lcfirst($value).".php";
                    if(!is_file(BASE_PATH.$controllerPath)){
                        $controllerPath = "controllers/".ucfirst($value).".php";
                        if(!is_file(BASE_PATH.$controllerPath)) {
                            if($num==0){
                                showErrors("Can't find the Controller!");
                            }
                            continue;
                        }
                        $controllerName = $value;
                        break;
                    }
                    $controllerName = $value;
                    break;
                }
            }else{
                $controllerName = DEFAULT_CONTROLLER;
                $controllerPath = "controllers/".DEFAULT_CONTROLLER.".php";
            }
            //先默认，控制器没有多级文件夹，不使用strrpos确定的原因是，如果为多级文件，文件名和控制器名字相同，易出现bug
            importFile($controllerPath);
            $controller = new $controllerName();
            $routes = substr($routes,strlen($controllerName)+1);
            //如果$routes 为false，则说明URL中不含method
            if($routes){
                $methodArray = explode("/",$routes);
                if(method_exists($controller,$methodArray[0])){
                    $method = $methodArray[0];
                }else{
                    showErrors("Can't find the method!");
                }
            }else{
                $method = DEFAULT_METHOD;
            }
            $controller->$method();

        }*/

    /**
     * Run Controller
     *
     * @return mixed
     */
    public function runController()
    {
        $routes = getRouteAll();
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
                        showErrors("Can't find the Controller!");
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
        //先默认，控制器没有多级文件夹，不使用strrpos确定的原因是，如果为多级文件，文件名和控制器名字相同，易出现bug
        importFile($controllerPath);
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