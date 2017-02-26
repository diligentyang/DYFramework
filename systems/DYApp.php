<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class DYApp
{

    public static $_classes;
    /**
     * Start app
     *
     * @return null
     */
    public function start()
    {
        $config = \systems\Factory::GetConfig();
        if ($config['Config']['auto_start_session']) {
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