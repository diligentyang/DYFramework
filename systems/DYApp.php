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
            dd($routesArray);
        }else{

        }

    }

}