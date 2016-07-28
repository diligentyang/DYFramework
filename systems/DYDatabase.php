<?php
defined('ACCESS') OR exit('No direct script access allowed');

class DYDatabase
{
    function __construct()
    {
        $this->createPDO();

    }

    function createPDO()
    {
        $db="";
        include("../config/database.php");
        foreach($db as $value){
            
        }

    }

    function query()
    {
        echo "query";
    }
}