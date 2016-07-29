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
        $chaset = $db['charset'];
        $dsn = "mysql:dbname=$dbname;host=$host";
        try {
            $pdo = new PDO($dsn, $db_user, $db_pass);
        } catch (PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            exit();
        }
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->exec("set name $chaset");
        return $pdo;
    }

    function query($sql = "", $mode = "array")
    {
        $sql = trim($sql);
        if ($sql == "") {
            showErrors("the mothe query neet at least one param!");
        }
        $query = $this->pdo->query($sql);

        if (!$query) {
            showErrors("the sql string is false");
        }
        if (strpos(strtolower($sql), "select") ===false) {
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
        return $res;
    }

    function bindquery($sql = "", $array, $mode = "array")
    {
        $sql = trim($sql);
        if ($sql == "") {
            showErrors("the mothe query neet at least one param!");
        }
        $query = $this->pdo->prepare($sql);
        $exec = $query->execute($array);
        if (!$exec) {
            showErrors("the sql string is false");
        }
        if (strpos(strtolower($sql), "select") === false) {
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
        return $res;

    }
}