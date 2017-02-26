config 配置文件

controllers 控制器

lib  工具类及用户扩展目录

models 模型

systems 框架核心文件

views 视图

web 静态文件(内含入口文件)

    /index.php 入口文件


控制器命名规则形如

controllers/ControTest 中的actionIndex方法

http://localhost/web/index.php/contro-test/index

要求控制器名字，符合大驼峰

可以控制多级目录，文件名要以大驼峰的方式命名同控制器



注：本框架还在开发阶段

# 框架运行流程

入口文件(`/web/index.php`)-->定义常量('/systems/DYConstant.php')-->自动加载类(`/systems/Autoload.php`)-->初始化框架(`systems\DYBase::init()`)-->启动框架创建APP实例(`Factory::GetDYApp()->start();`)-->路由解析(利用工厂方法'Factory::GetRoute()'得到控制器和方法)-->加载控制器('runController')-->返回结果

