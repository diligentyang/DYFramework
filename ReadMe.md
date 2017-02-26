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

## 初始化框架

调用\systems\Factory::GetConfig()工厂方法加载配置文件，并读取其中的environment项，根据设置的值进行相应的错误设置。

其中Config类用工厂方法实例化，并使用**注册器模式**添加到了全局的树上。

Config类implements 标准库中的ArrayAccess，实现了通过数组的方式加载相应的配置文件，简单灵活。

## 启动框架创建APP实例

```
static public function run()
    {
        //$route = Factory::GetRoute();
        Factory::GetDYApp()->start();
    }
```

利用**简单工厂模式**，创建了一个APP实例，执行了其中的start方法，加载控制器，开启session。

## 路由解析(\systems\Route.php)

GetFormatUrl()通过$routes = $_SERVER['REQUEST_URI'];获取当前的URL路径，然后按着

action/index -> Action控制器下的actionIndex方法

admin/admin-welcome/index -> admin目录下的AdminWelcome控制器下的actionIndex

来格式化字符串，改变大小写，去掉分隔符等。

然后调用GetController()获得控制器名称

GetMethod()获得控制器中的方法名。

## 加载控制器

通过DYApp生成的APP实例，执行runController()，获取路由解析后获得的控制器和方法，进行实例化，并调用控制器的方法。

## 返回结果

经过上述过程以后就可以简单的执行控制器中的方法，并显示结果了。

其实到这里才算是刚刚开始，下面就是扩大框架，为框架宝宝增加功能。

## 控制器和模型

控制器类(DYController)和模型(DYModel)都分别继承了DYConModBase类，其中包含他们公有的方法，比如session的获取和设置，Flash Session的获取和设置，redirect方法等。

控制器DYController中又含有加载模型和视图的方法。

## 工具类

/lib目录下用于存放工具类

比如Database文件夹中是Mysqli和Pdo类，关于这两个类的实现，应用了**单例模式**，**适配器模式**，和**工厂方法模式**。

通过implements IDataBase接口实现了相同的方法，并可以通过\lib\Factory::GetMySQL()根据配置文件来获取数据库实例。

分别使用**单例模式**(三私一共)防止了数据库多次连接的浪费。









