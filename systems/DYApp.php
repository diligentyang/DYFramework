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
        if($routes){
            $routesArray = explode("/",$routes);
            foreach($routesArray as $value){
                $controllerPath = "controllers/".lcfirst($value).".php";
                if(!is_file(BASE_PATH.$controllerPath)){
                    $controllerPath = "controllers/".ucfirst($value).".php";
                    if(!is_file(BASE_PATH.$controllerPath)) {
                        continue;
                    }
                    break;
                }
                break;
            }
        }else{
            $controllerPath = "controllers/".DEFAULT_CONTROLLER.".php";
        }
        //$method = DEFAULT_METHOD;
        importFile($controllerPath);

    }

}