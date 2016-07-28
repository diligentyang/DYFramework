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

function importFile($fileName)
{
    $fileName = BASE_PATH . $fileName;
    if (is_file($fileName)) {
        include_once($fileName);
    } else {
        showErrors("The File Path is not available!");
    }
}

