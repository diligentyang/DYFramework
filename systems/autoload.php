<?php

defined("ACCESS") or define("ACCESS", true);

/**
 * Auto loading
 *
 * @param string $fileName File name
 *
 * @return null
 */
function loader($fileName)
{
    $fileName = SYSTEMS_PATH . $fileName . ".php";
    include_once "$fileName";
}

spl_autoload_register("loader");
