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
        $controller = Factory::GetRoute()->controller;

        $action = Factory::GetRoute()->method;
    }


}