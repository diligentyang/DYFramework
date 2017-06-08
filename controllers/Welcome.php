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
}