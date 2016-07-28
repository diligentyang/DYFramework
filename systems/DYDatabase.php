<?php
defined('ACCESS') OR exit('No direct script access allowed');

class DYDatabase
{
    function __construct()
    {
        $this->createPDO();

    }

    function createPDO()
    {
        $db = "";
        include("../config/database.php");
        $count = 0;
        foreach ($db as $value) {
            if ($count === 0) {
                continue;
            }
            if (!$value) {
                showErrors("database config is not set correctly");
            }
        }
        $dbname = $db['database'];
        $host = $db['host'];
        $db_user = $db['username'];
        $db_pass = $db['password'];
        $dsn = "mysql:dbname=$dbname;host=$host";
        try{
            $pdo=new PDO($dsn,$db_user,$db_pass);
        }catch(PDOException $e){
            echo '数据库连接失败'.$e->getMessage();
            exit();
        }


    }

    function query()
    {
        echo "query";
    }
}