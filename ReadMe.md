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

## 入口文件

起始位置定义

```
defined("ACCESS") or define("ACCESS", true);
```

在其他文件中的起始位置添加
```
defined('ACCESS') OR exit('No direct script access allowed');
```

如果不是从入口文件进入的，属于非法访问，被禁止。

## 定义常量

在/systems/DYConstant.php中分别定义了目录分隔符(DS)，根目录(BASE_PATH),项目url根地址(BASE_URL)等常量。

## 自动加载

```
public static $classMap = array();
```

定义$classMap，将加载过的类保存进去，在第二次加载时可直接调用，增加加载速度。

运用spl_autoload_register()方法，根据命名空间实现自动加载，符合PSR规范。

```
static function loader($fileName)
    {
        if(isset(self::$classMap[$fileName])){
            return true;
        } else {
            $fileName = str_replace("\\", DS,$fileName);
            $file = BASE_PATH.$fileName.".php";
            if(is_file($file)){
                include $file;
                self::$classMap[$fileName] = $fileName;
            }else{
                ;echo "请检查所引用类".$fileName."的命名空间是否正确";exit();
            }
        }
    }
```
