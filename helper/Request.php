<?php

defined("ACCESS") or define("ACCESS", true);

class Request
{
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
    }

    public function isGet()
    {
        var_dump($_SERVER['HTTP_REFERER']);
        return $_SERVER['REQUEST_METHOD'] === 'GET' ? true : false;
    }

}
