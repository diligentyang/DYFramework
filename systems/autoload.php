<?php

defined("ACCESS") or define("ACCESS", true);
function loader($fileName)
{
    $fileName = SYSTEMS_PATH . $fileName . ".php";
    include_once($fileName);
    echo "<br>";
    echo $fileName;
    echo "<br>";
}

spl_autoload_register("loader");
?>