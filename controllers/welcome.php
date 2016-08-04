<?php

class Welcome extends DYController
{
    public function actionIndex()
    {
        echo $this->base_url();
        echo "<br>";
        echo $this->site_url("welcome/index");
        echo "<br>";
        echo "Welcome to use DY Frame Work!";
    }
}