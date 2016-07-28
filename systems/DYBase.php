<?php

defined("ACCESS") or define("ACCESS",true);

class DYBase
{
    //application list
    static private $application;
    //class list
    static private $class;

    function init()
    {
        switch (ENVIRONMENT) {
            case "dev" :
                error_reporting(-1);
                ini_set('display_errors', 1);
                break;
            case "pro" :
                ini_set('display_errors', 0);
                if (version_compare(PHP_VERSION, '5.3', '>=')) {
                    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
                } else {
                    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
                }
                break;
            default :
                exit("The application environment is not set correctly.");
        }

    }
}
