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
        $this->db->query("set names $charset");
    }

    public static function getInstance($dbname, $host, $port,$db_user, $db_pwd, $charset)
    {
        if(!self::$_instance){
            self::$_instance = new self($dbname, $host, $port,$db_user, $db_pwd, $charset);
        }
        return self::$_instance;
    }


    function query($strSql, $mode)
    {
        // TODO: Implement query() method.
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