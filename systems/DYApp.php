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

        importFile($controllerPath);
        $controller = new $controllerName();
        $method = DEFAULT_METHOD;
        $controller->$method();

    }

}