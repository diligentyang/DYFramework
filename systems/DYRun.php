<?php
namespace systems;
defined('ACCESS') OR exit('No direct script access allowed');

class DYRun
{
    /**
     * Run app
     *
     * @return null
     */
    static public function run()
    {
        //$route = Factory::GetRoute();
        Factory::GetDYApp()->start();
    }

}