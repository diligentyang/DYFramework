<?php
namespace controllers;

use JasonGrimes\Paginator;

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
        $totalItems = 1000;
        $itemsPerPage = 50;
        $currentPage = 1;
        var_dump($_SERVER);
        $urlPattern = SITE_URL.'welcome/pagination/(:num)';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        $this->view("pagination",['paginator'=>$paginator]);
    }
}