<?php
namespace controllers;

class Welcome extends \systems\DYController
{
    public function actionIndex()
    {
        $data = array("id"=>'1',"name"=>'ysy');

        $model = $this->model('TestModel');
        $model->testModelMethod();
        $model->aaa();
        $passwd = new \lib\Password();
        echo $passwd->generatePasswordHash("222222");
        $this->view("request", $data);


    }

    function actionTest()
    {
        echo "welcome test";
    }
}