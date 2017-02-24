<?php
namespace lib\Database;

use \systems\DYBaseFunc as DYBaseFunc;

class Mysqli implements IDataBase
{
    private static $_instance = null;
    private $db;

    private function __construct($dbname, $host, $port,$db_user, $db_pwd, $charset)
    {
        $this->db = mysqli_connect($host, $db_user, $db_pwd, $dbname, $port);
        mysqli_query($this->db ,"set names $charset");
    }

    public static function getInstance($dbname, $host, $port,$db_user, $db_pwd, $charset)
    {
        if(!self::$_instance){
            self::$_instance = new self($dbname, $host, $port,$db_user, $db_pwd, $charset);
        }
        return self::$_instance;
    }


    function query($strSql, $mode = "array")
    {
        $strSql = trim($strSql);
        if($strSql==""){
            DYBaseFunc::showErrors("Query cannot be empty!");
        }
        $query = mysqli_query($this->db, $strSql);
        if(!$query){
           dd("GG");
        }
        if (strpos(strtolower($strSql), "select") ===false) {
            return $query;
        }

        $res = mysqli_fetch_all($query, MYSQLI_ASSOC);
//        switch ($mode) {
//            case 'array' :
//                $res = $query->fetchAll(\PDO::FETCH_ASSOC);
//                break;
//            case 'object' :
//                $res = $query->fetchAll(\PDO::FETCH_OBJ);
//                break;
//            case 'count':
//                $res = $query->rowCount();
//                break;
//            default:
//                DYBaseFunc::showErrors("SQLERROR: please check your second param!");
//        }
        return $res;
    }

    function insert($table, $arrayDataValue, $escape)
    {
        // TODO: Implement insert() method.
    }

    function update($table, $arrayDataValue, $where, $escape)
    {
        // TODO: Implement update() method.
    }

    function delete($table, $where)
    {
        // TODO: Implement delete() method.
    }

    function getColumns($table)
    {
        // TODO: Implement getColumns() method.
    }
}