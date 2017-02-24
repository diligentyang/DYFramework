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
require_once "../systems/DYConstant.php"; //常量定义
require_once "../systems/Autoload.php";
spl_autoload_register('\systems\Autoload::loader');

$db = \lib\Database\Pdo::getInstance('test', 'localhost', 'root', '905407339', 'UTF-8');
var_dump($db);
systems\DYBase::init();
