<?php
namespace lib\Database;
use \systems\DYBaseFunc as DYBaseFunc;

class Pdo implements IDataBase
{
    private static $_instance = null;
    private $db;

    private function __construct($dbname, $host, $db_user, $db_pwd, $charset)
    {
        $dsn = "mysql:host=$host;dbname=$dbname";
        try {
            $this->db = new \PDO($dsn, $db_user, $db_pwd);
        } catch (\PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            exit();
        }
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->exec("set names $charset");
    }

    public static function getInstance($dbname, $host, $db_user, $db_pwd, $charset)
    {
        if(!self::$_instance){
            self::$_instance = new self($dbname, $host, $db_user, $db_pwd, $charset);
        }
        return self::$_instance;
    }


    function query($strSql, $mode = "array")
    {
        $strSql = trim($strSql);
        if($strSql==""){
            DYBaseFunc::showErrors("Query cannot be empty!");
        }
        $query = $this->db->query($strSql);
        if(!$query){
            DYBaseFunc::showErrors("DataBase error : ".$this->getPDOError());
        }
        if (strpos(strtolower($strSql), "select") ===false) {
            return $query;
        }

        switch ($mode) {
            case 'array' :
                $res = $query->fetchAll(\PDO::FETCH_ASSOC);
                break;
            case 'object' :
                $res = $query->fetchAll(\PDO::FETCH_OBJ);
                break;
            case 'count':
                $res = $query->rowCount();
                break;
            default:
                DYBaseFunc::showErrors("SQLERROR: please check your second param!");
        }
        return $res;


    }

    /**
     * 获取PDO执行的错误
     *
     * @return mixed
     */
    private function getPDOError()
    {
        if ($this->db->errorCode() != '00000') {
            $arrayError = $this->db->errorInfo();
            return $arrayError[2];
        }
    }

}