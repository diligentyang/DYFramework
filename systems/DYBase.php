<?php
namespace systems;
/**
 * DYFrameword DYBase
 * PHP version 5
 *
 * @author diligentyang <diligentyang@vip.qq.com>
 * @link   https://github.com/diligentyang/DYFramework.git
 *
 */

defined('ACCESS') OR exit('No direct script access allowed');

/**
 * Class DYBase
 * To run DYFramework
 *
 * @author diligentyang <diligentyang@vip.qq.com>
 *
 */
class DYBase
{

    static function init()
    {
        $config = \systems\Factory::GetConfig();
        switch ($config['config']['environment']) {
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

        DYRun::run();
    }


}
