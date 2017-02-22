<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class DYApp
{

    private static $_classes;
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
     * Run Controller
     *
     * @return null
     */
    public function runController()
    {

        $controller = str_replace("/",DS,Factory::GetRoute()->controller);
        $controller = '\\controllers\\'.$controller;
        if(isset(self::$_classes[$controller])){
            $contro = self::$_classes[$controller];
        } else{
            $contro = new $controller();
            self::$_classes[$controller] = $contro;
        }
        $action = "action".Factory::GetRoute()->method;
        $contro->$action();
    }


}