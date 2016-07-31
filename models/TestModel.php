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
        $res=$this->db()->query("select * from user");
        return $res;
    }
}