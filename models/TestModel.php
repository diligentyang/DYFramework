<?php
namespace models;

defined('ACCESS') OR exit('No direct script access allowed');

Class TestModel extends \systems\DYModel
{
    function __construct()
    {

    }

    function testModelMethod()
    {
        echo "testModelMethod";
    }

    function aaa()
    {
        echo "aaa";
    }
}