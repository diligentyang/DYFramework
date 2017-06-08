<?php
namespace controllers;

use lib\Paginator;

class Welcome extends \systems\DYController
{
    public function actionIndex()
    {
        $this->view("index");
    }

    //模型及工具类测试
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

    //markdown to HTML
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

    //分页
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

    //模板引擎
    function actionBlade()
    {
        $data = ['a'=>1,'b'=>2];
        $this->RenderView("hello",$data);
    }

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

    //获取客户端ip
    function actionGetip()
    {
        dump(\lib\Request::ip(0));
    }

    //表单验证
    function actionValidate()
    {
        
    }
}