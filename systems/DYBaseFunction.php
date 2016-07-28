<?php
defined('ACCESS') OR exit('No direct script access allowed');

function showErrors($error = "")
{
    echo "<h2>" . $error . "<h2>";
    exit();
}

/**
 * @return string or false
 */
function getRouteAll()
{
    $route = $_SERVER['REQUEST_URI'];
    if(!strpos($route,"index.php")){
        $route .="index.php";
    }
    $route = substr($route, strpos($route, "index.php") + 10);
    return $route;
}

function segment($a = 3)
{
    $route = getRouteAll();
    if (!$route) {
        showErrors("please check your url!");
    }
    $route = explode("/", $route);
    return $route[$a - 1];
}

function importFile($filePath)
{
    $filePath = BASE_PATH . $filePath;
    if (is_file($filePath)) {
        include_once($filePath);
    } else {
        showErrors("The File Path is not available!");
    }
}

