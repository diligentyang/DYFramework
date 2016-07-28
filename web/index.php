<?php

defined("ACCESS") or define("ACCESS",true);
function dd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit();
}

require_once("../config/config.php");
require_once("../config/database.php");
require_once("../systems/DYConstant.php");
require_once("../systems/DYBASE.php");
require_once("../systems/autoload.php");