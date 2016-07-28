<?php

defined("ACCESS") or define("ACCESS",true);

class DYApp
{
    public function start()
    {
        if(AUTO_START_SESSION){
            if(!session_id()){
                session_start();
            }
        }

        $this->runController();
    }

    public function runController()
    {
        $routes = getRouteAll();
        $controllerName="";
        if($routes){
            $routesArray = explode("/",$routes);
            foreach($routesArray as $value){
                $controllerPath = "controllers/".lcfirst($value).".php";
                if(!is_file(BASE_PATH.$controllerPath)){
                    $controllerPath = "controllers/".ucfirst($value).".php";
                    if(!is_file(BASE_PATH.$controllerPath)) {
                        continue;
                    }
                    $controllerName = $value;
                    break;
                }
                $controllerName = $value;
                break;
            }
        }else{
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
                showErrors("Please check your method in your url!");
            }
        }else{
            $method = DEFAULT_METHOD;
        }
        $controller->$method();

    }

}