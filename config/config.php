<?php
defined('ACCESS') OR exit('No direct script access allowed');
return array(
    //环境配置,dev,开发环境(开启错误提示),pro产品环境(屏蔽错误提示)
    'environment' => 'dev',
    //默认访问的控制器
    'defalut_controller' => 'Welcome',
    //默认访问的控制器的action ID
    'defalut_method'=>'index',
    //是否自动开启session
    'auto_start_session'=>true,
);