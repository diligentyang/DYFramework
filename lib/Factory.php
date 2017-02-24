<?php
namespace lib;

use \systems\Register as Register;

defined('ACCESS') OR exit('No direct script access allowed');

class Factory
{
    static function GetMySQL()
    {
        if(Register::get("mysql")){
            return Register::get("mysql");
        }else{
            $config = \systems\Factory::GetConfig();
            //$dbname, $host, $db_user, $db_pwd, $charset
            Register::set("mysql", \lib\Database\Pdo::getInstance($config['database']['database'], $config['database']['host'], $config['database']['port'], $config['database']['username'], $config['database']['password'], $config['database']['charset']));
            return Register::get("mysql");
        }
    }
}