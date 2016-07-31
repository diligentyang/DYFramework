<?php

defined("ACCESS") or define("ACCESS", true);

Class TestModel extends DYModel
{
    function __construct()
    {

    }

    function testModelMethod()
    {
        echo "testModelMethod";
    }
}