<?php

defined("ACCESS") or define("ACCESS", true);

class Test extends DYController
{
    function actionIndex()
    {
        $this->model("TestModel")->testModelMethod();
    }

    function actionArticle()
    {
        $model=$this->model("Admin/AdminModel");
        $model->test();
        $this->db()->query();
    }
}