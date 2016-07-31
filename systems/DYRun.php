<?php

defined("ACCESS") or define("ACCESS", true);

class DYRun
{
    /**
     * Run app
     *
     * @return null
     */
    static public function run()
    {
        $app = new DYApp();
        $app->start();
    }

}