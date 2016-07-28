<?php
    defined('ACCESS') OR exit('No direct script access allowed');

    //环境配置,dev,开发环境(开启错误提示),pro产品环境(屏蔽错误提示)
    $config['environment'] = 'dev';
    //默认访问的控制器
    $config['defalut_controller'] = 'welcome';
    //默认访问的控制器的方法
    $config['defalut_function'] = 'index';
    //是否自动开启session
    $config['auto_start_session'] = true;