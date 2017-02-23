<?php
namespace controllers;

class Welcome extends \systems\DYController
{
    public function actionIndex()
    {
        $data = array("id"=>'1',"name"=>'ysy');
        $this->view("request", $data);
    }

    function actionTest()
    {
        echo "welcome test";
    }
}