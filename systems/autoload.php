<?php

defined("ACCESS") or define("ACCESS", true);
function loader($fileName)
{
    $fileName = SYSTEMS_PATH . $fileName . ".php";
    include_once($fileName);
}

spl_autoload_register("loader");
?>