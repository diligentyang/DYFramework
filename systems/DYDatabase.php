<?php
defined('ACCESS') OR exit('No direct script access allowed');

class DYDatabase
{
    public $pdo;

    function __construct()
    {
        $this->pdo = $this->createPDO();

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
        try {
            $pdo = new PDO($dsn, $db_user, $db_pass);
        } catch (PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            exit();
        }
        return $pdo;
    }

    function query($sql = "", $mode = "array")
    {
        $sql = trim($sql);
        if ($sql == "") {
            showErrors("the mothe query neet at least one param!");
        }
        $query = $this->pdo->query($sql);
        if (!query) {
            showErrors("the sql string is false");
        }
        if (!strpos(strtolower($sql), "select")) {
            return $query;
        }

        switch ($mode) {
            case 'array' :
                $res = $query->fetch(PDO::FETCH_ASSOC);
                break;
            case 'object' :
                $res = $query->fetchObject();
                break;
            case 'count':
                $res = $query->rowCount();
                break;
            default:
                showErrors("SQLERROR: please check your second param!");
        }


    }
}