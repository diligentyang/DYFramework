<?php
defined('ACCESS') OR exit('No direct script access allowed');

foreach($config as $value){
    if(!$value){
        exit("The application config is not set correctly");
    }
}

//开发环境
defined("ENVIRONMENT") or define("ENVIRONMENT",$config['environment']);
//默认控制器
defined("DEFAULT_CONTROLLER") or define("DEFAULT_CONTROLLER",$config['defalut_controller']);
//默认方法
defined("DEFAULT_METHOD") or define("DEFAULT_METHOD",$config['defalut_method']);
//session开启
defined("AUTO_START_SESSION") or define("AUTO_START_SESSION",$config['auto_start_session']);
//目录分隔符
defined("DS") or define("DS",DIRECTORY_SEPARATOR);
//根目录 D:\wampserver\www\MyFramework
defined("BASE_PATH") or define("BASE_PATH",substr(dirname(__FILE__),0,strrpos(dirname(__FILE__),DS)));
//核心目录 D:\wampserver\www\MyFramework\systems
defined("SYSTEMS_PATH") or define("SYSTEMS_PATH",dirname(__FILE__));
//项目名称
defined("ITEM_NAME") or define("ITEM_NAME",explode(DS,dirname(__FILE__))[count(explode(DS,dirname(__FILE__)))-2]);
//项目url根地址对应的web目录
defined("BASE_URL") or define("BASE_URL",'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
//用户自定义扩展目录
