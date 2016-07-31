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

require_once "../config/config.php";
require "../config/database.php";
require_once "../systems/DYConstant.php";
require_once "../systems/DYBASE.php";
require_once "../systems/autoload.php";
DYBase::init();