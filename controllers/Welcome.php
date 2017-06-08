<?php
namespace controllers;

use lib\Paginator;

class Welcome extends \systems\DYController
{
    public function actionIndex()
    {
        $this->view("index");
    }

    function actionTest()
    {
        dump(array(1,2,3,4,5));
        $data = array("id"=>'1',"name"=>'ysy');

        $model = $this->model('TestModel');
        $model->testModelMethod();
        $model->aaa();
        $passwd = new \lib\Password();
        echo $passwd->generatePasswordHash("222222");
        $this->view("request", $data);
    }

    function actionMarkdown()
    {
        $markdown =<<<'EOF'
## h1

- askdljf
- askldjf
EOF;
        $parser = new \cebe\markdown\Markdown();
        echo $parser->parse($markdown);
    }

    function actionPagination(){
        //分页说明https://github.com/jasongrimes/php-paginator
        $totalItems = 100;
        $itemsPerPage = 5;
        //$currentPage = 1;
        $currentPage = $this->segment(3) ? $this->segment(3) : 1;
        $urlPattern = SITE_URL.'welcome/pagination/(:num)';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow(5);//显示的最多页数
        $this->view("pagination",['paginator'=>$paginator]);
        echo "当前页".$currentPage;
    }

    //验证码
    function actionCaptcha(){
        $builder = new \Gregwar\Captcha\CaptchaBuilder;
        $builder->build();
//        $cap = $builder->getPhrase();
//        echo $cap;
        header('Content-type: image/jpeg');
        $builder->output();
    }

    function actionBlade()
    {
        $path = [BASE_PATH.'views'];         // 视图文件目录，这是数组，可以有多个目录
        $cachePath = BASE_PATH.'cache';     // 编译文件缓存目录

        $compiler = new \Xiaoler\Blade\Compilers\BladeCompiler($cachePath);

        $engine = new \Xiaoler\Blade\Engines\CompilerEngine($compiler);
        $finder = new \Xiaoler\Blade\FileViewFinder($path);

// 实例化 Factory
        $factory = new \Xiaoler\Blade\Factory($engine, $finder);

// 渲染视图并输出
        echo $factory->make('hello', ['a' => 1, 'b' => 2])->render();
    }
}