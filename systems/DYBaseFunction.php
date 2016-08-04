<?php
/**
 * DYBaseFunction
 * PHP version 5
 *
 * @author diligentyang <diligentyang@vip.qq.com>
 * @link   https://github.com/diligentyang/DYFramework.git
 */
defined('ACCESS') OR exit('No direct script access allowed');

/**
 * Show errors
 *
 * @param string $error error message
 *
 * @return null
 */
function showErrors($error = "")
{
    echo "<h2>" . $error . "<h2>";
    exit();
}

/**
 * Get Route
 *
 * @return string|false
 */
function getRouteAll()
{
    $route = $_SERVER['REQUEST_URI'];
    if (!strpos($route, "index.php")) {
        $route .= "index.php";
    }
    $route = substr($route, strpos($route, "index.php") + 10);
    return $route;
}

/**
 * Get uri segment
 *
 * @param int $a the position
 *
 * @return mixed
 */
function segment($a = 3)
{
    $route = getRouteAll();
    if (!$route) {
        showErrors("please check your url!");
    }
    $route = explode("/", $route);
    return $route[$a - 1];
}

/**
 * Import a php file
 *
 * @param string $filePath php file path
 *
 * @return null
 */
function importFile($filePath)
{
    $filePath = BASE_PATH . $filePath;
    if (is_file($filePath)) {
        include_once "$filePath";
    } else {
        showErrors("The File Path is not available!");
    }
}

/**
 * Load class needed
 *
 * @param string       $file  file name
 * @param array|string $class class name
 *
 * @return null
 */
function loadClass($file, $class)
{
    if (is_array($class)) {
        foreach ($class as $val) {
            $filePath = BASE_PATH . $file . DS . $val . ".php";
            if (!is_file($filePath)) {
                showErrors("don't find $val.php in helper!");
            }
            include_once "$filePath";
        }
    } else {
        $filePath = BASE_PATH . $file . DS . $class . ".php";
        if (!is_file($filePath)) {
            showErrors("don't find $file.php in helper!");
        }
        include_once "$filePath";
    }
}

/**
 * Get base url
 *
 * @param string route url
 *
 * @return string
 */
function base_url($route = "")
{
    return $route == "" ? BASE_URL : BASE_URL . $route;
}

/**
 * Get site url
 *
 * @param string route url
 *
 * @return string
 */
function site_url($route = "")
{
    return $route == "" ? SITE_URL : SITE_URL . $route;
}


