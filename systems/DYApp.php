<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

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
     * Run Controller
     *
     * @return mixed
     */
    public function runController()
    {
        $controller = str_replace("/",DS,Factory::GetRoute()->controller);
        DYBaseFunc::importFile("controllers".DS.$controller.".php");
        $arr = explode(DS, $controller);
        $contro = new $arr[count($arr)-1];
        $action = "action".Factory::GetRoute()->method;
        $contro->$action();
    }


}