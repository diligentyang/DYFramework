<?php
/**
 * DYFramework
 * PHP version 5
 *
 * @author  diligentyang <diligentyang@vip.qq.com>
 * @license https://github.com/diligentyang/DYFramework.git license v1.0
 * @link    https://github.com/diligentyang/DYFramework.git
 */

defined("ACCESS") or define("ACCESS", true);
/**
 * Print variable content
 *
 * @param mixed $var Variable to print
 *
 * @return null
 */
function dd($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit();
}

require_once "../config/config.php"; //配置文件
require "../config/database.php"; //数据库配置文件
require_once "../systems/DYConstant.php"; //常量定义
require_once "../systems/Autoload.php";
//require_once "../systems/DYBASE.php";
//require_once "../systems/autoload.php";

spl_autoload_register('\systems\Autoload::loader');

$config = new \lib\Config(BASE_PATH."config");
var_dump($config['TestConfig']);

systems\DYBase::init();
