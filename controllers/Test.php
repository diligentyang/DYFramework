<?php

defined("ACCESS") or define("ACCESS", true);

class Test extends DYController
{
    function __construct()
    {
        parent::__construct();
        $this->helper("Page");
    }

    function actionIndex()
    {
        $this->model("TestModel")->testModelMethod();
        $data['admin'] = "123456";
        $this->view("test",$data);
    }

    function actionArticle()
    {
        $model=$this->model("Admin/AdminModel");
        $model->test();
        $res=$this->db()->query("select * from user");
        var_dump($res);
        //如果能查到东西，就返回查询结果数组，否则返回false
        $res1 = $this->db()->bindquery("select * from user where username=? and password=?",array("admin","123456"));
        var_dump($res1);
    }

    function actionSeg()
    {
        echo segment(3);
    }

    function actionPage()
    {
        $page = new page();
        $page -> page_list();
    }

    function actionArr()
    {
        $this->helper(array("Page1","Page2"));
        $page1 = new Page1();
        $page1->test1();
        $page2 = new Page2();
        $page2->test2();
    }

    function actionRedirect()
    {
        $this->redirect("test/Index");
    }

    //哈希密码
    function actionPwd()
    {
        $hash = $this->generatePasswordHash("123456");
        dd($hash);
        //output: $2y$12$Zp83q70rweYxsi3ZyzDpY.NQYnfzNg6heZvs806SmsUmDhOWja53m
    }

}