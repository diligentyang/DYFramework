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
require_once "../systems/DYConstant.php"; //常量定义
require_once "../systems/Autoload.php";
require_once "../vendor/autoload.php";
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
spl_autoload_register('\systems\Autoload::loader');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('framworkLog');
$log->pushHandler(new StreamHandler(BASE_PATH.'/log/framelog.log', Logger::WARNING));

// add records to the log
$log->warning('警告：鲁班大师');
$log->error('Bar');
echo "1111111";
systems\DYBase::init();
