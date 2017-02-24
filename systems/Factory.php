<?php
/**
 * Created by PhpStorm.
 * User: diligentyang
 * Date: 2017/2/21
 * Time: 19:55
 */
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class Factory
{
    static function GetRoute()
    {
        if(Register::get("route")){
            return Register::get("route");
        }else{
            Register::set("route",new \systems\Route());
            return Register::get("route");
        }
    }

    static function GetDYApp()
    {
        if(Register::get("DYApp")){
            return Register::get("DYApp");
        }else{
            Register::set("DYApp",new \systems\DYApp());
            return Register::get("DYApp");
        }
    }

    static function GetConfig()
    {
        if(Register::get("Config")){
            return Register::get("Config");
        }else{
            Register::set("Config", new Config(BASE_PATH."config"));
            return Register::get("Config");
        }
    }
}