# 安装

git clone https://github.com/diligentyang/DYFramework.git

composer install

# 目录结构

cache 模板缓存文件

config 配置文件

controllers 控制器

lib  工具类及用户扩展目录

models 模型

systems 框架核心文件

vendor 依赖扩展及自动加载

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

现在已经升级为 composer 自动加载

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

# 加载视图

提供了两种模式

一种是直接在控制器中 `$this->view('example',$data)` ，会加载 views/example.php|.html|.htm，$data为一个数组 。
另一种是用laravel的blade模板引擎，例如`$this->RenderView("hello",$data);`，会加载views/hello.balde.php

关于模板引擎的详细用法：https://docs.golaravel.com/docs/5.1/blade/

# 分页类

```
use lib\Paginator;
```

```
//分页说明https://github.com/jasongrimes/php-paginator
$totalItems = 100;
$itemsPerPage = 5;
//$currentPage = 1;
$currentPage = $this->segment(3) ? $this->segment(3) : 1;//当前页
$urlPattern = SITE_URL.'welcome/pagination/(:num)';//url
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
$paginator->setMaxPagesToShow(5);//显示的最多页数
$this->view("pagination",['paginator'=>$paginator]);
echo "当前页".$currentPage;
```
# 文件上传

```
//文件上传
    function actionUpload()
    {
        if(\lib\Request::isPost()){
            $storage = new \Upload\Storage\FileSystem(BASE_PATH.'upload');
            $file = new \Upload\File('foo', $storage);//foo和前端表单的id对应

            // Optionally you can rename the file on upload
            $new_filename = uniqid();
            $file->setName($new_filename);

            // Validate file upload
            // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
            $file->addValidations(array(
                // Ensure file is of type "image/png"
                new \Upload\Validation\Mimetype('image/png'),

                //You can also add multi mimetype validation
                //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

                // Ensure file is no larger than 5M (use "B", "K", M", or "G")
                new \Upload\Validation\Size('2M')
            ));

            // Access data about the file that has been uploaded
            $data = array(
                'name'       => $file->getNameWithExtension(),
                'extension'  => $file->getExtension(),
                'mime'       => $file->getMimetype(),
                'size'       => $file->getSize(),
                'md5'        => $file->getMd5(),
                'dimensions' => $file->getDimensions()
            );

            // Try to upload file
            try {
                // Success!
                $file->upload();
                dump($data);
            } catch (\Exception $e) {
                // Fail!
                $errors = $file->getErrors();
                dump($errors);
            }
        }
        $this->view("upload");
    }
```


# 表单验证

```
 //表单验证
    /*
     *
            required - Required field
            equals - Field must match another field (email/password confirmation)
            different - Field must be different than another field
            accepted - Checkbox or Radio must be accepted (yes, on, 1, true)
            numeric - Must be numeric
            integer - Must be integer number
            boolean - Must be boolean
            array - Must be array
            length - String must be certain length
            lengthBetween - String must be between given lengths
            lengthMin - String must be greater than given length
            lengthMax - String must be less than given length
            min - Minimum
            max - Maximum
            in - Performs in_array check on given array values
            notIn - Negation of in rule (not in array of values)
            ip - Valid IP address
            email - Valid email address
            url - Valid URL
            urlActive - Valid URL with active DNS record
            alpha - Alphabetic characters only
            alphaNum - Alphabetic and numeric characters only
            slug - URL slug characters (a-z, 0-9, -, _)
            regex - Field matches given regex pattern
            date - Field is a valid date
            dateFormat - Field is a valid date in the given format
            dateBefore - Field is a valid date and is before the given date
            dateAfter - Field is a valid date and is after the given date
            contains - Field is a string and contains the given string
            creditCard - Field is a valid credit card number
            instanceOf - Field contains an instance of the given class
            optional - Value does not need to be included in data array. If it is however, it must pass validation.

        document : https://github.com/vlucas/valitron
     */
    function actionValidate()
    {
        if(\lib\Request::isPost()){
            $v = new \Valitron\Validator(\lib\Request::post());
            $v->rule('required', ['username','email'])->message("{field}不能为空");
            $v->rule('lengthBetween','username',3,6)->message("{field}必须为3-6个字符");
            $v->rule('email', 'email')->message("{field}格式不正确");
            $v->labels(array(
                'username' => '用户名',
                'email' => '邮箱'
            ));
            if($v->validate()) {
                echo "Yay! We're all good!";
            } else {
                // Errors
                dump($v->errors());
            }
        }
        $this->view("validate");
    }
```

# 验证码

```
//验证码
    /*
     *  You can then save it to a file :

            <?php

            $builder->save('out.jpg');

            Or output it directly :

            <?php

            header('Content-type: image/jpeg');
            $builder->output();

            Or inline it directly in the HTML page:

            <img src="<?php echo $builder->inline(); ?>" />
     */
    function actionCaptcha(){
        $builder = new \Gregwar\Captcha\CaptchaBuilder;
        $builder->build();
//        $cap = $builder->getPhrase();
//        echo $cap;
        header('Content-type: image/jpeg');
        $builder->output();
    }
```


