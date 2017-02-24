<?php
namespace lib\Database;

class Pdo implements IDataBase
{
    private static $_instance = null;
    private $db;

    private function __construct($dbname, $host, $db_user, $db_pwd, $charset)
    {
        $dsn = "mysql:host=$host;dbname=$dbname";
        try {
            $this->db = new \PDO($dsn, $db_user, $db_pwd);
            echo "OK!";
        } catch (\PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            exit();
        }
//        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//        $this->db->exec("set names $charset");
    }

    public static function getInstance($dbname, $host, $db_user, $db_pwd, $charset)
    {
        if(!self::$_instance){
            self::$_instance = new self($dbname, $host, $db_user, $db_pwd, $charset);
        }
        return self::$_instance;
    }


    function query()
    {
        echo "执行查询语句";
    }
}