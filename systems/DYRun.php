<?php

defined("ACCESS") or define("ACCESS",true);

class DYRun
{
    static public function run()
    {
        $app = new DYApp();
        $app->start();
    }

}