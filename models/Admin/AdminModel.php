<?php

defined("ACCESS") or define("ACCESS", true);

class AdminModel
{
    function __construct()
    {
        echo "Admin/AdminModel";
    }

    function test()
    {
        echo "AdminModel--test";
    }
}