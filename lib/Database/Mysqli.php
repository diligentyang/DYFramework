<?php
namespace lib\Database;

use \systems\DYBaseFunc as DYBaseFunc;

class Mysqli implements IDataBase
{
    private static $_instance = null;
    private $db;

    /**
     * Mysqli constructor.
     * @param $dbname
     * @param $host
     * @param $port
     * @param $db_user
     * @param $db_pwd
     * @param $charset
     */
    private function __construct($dbname, $host, $port,$db_user, $db_pwd, $charset)
    {
        ini_set("display_errors","On");
        error_reporting(E_ERROR | E_PARSE);
        $this->db = mysqli_connect($host, $db_user, $db_pwd, $dbname, $port);
        if(!$this->db){
            DYBaseFunc::showErrors("错误代码：".mysqli_connect_errno()." ERROR : ".mysqli_connect_error());
        }
        mysqli_query($this->db ,"set names $charset");
    }

    /**
     * 建立连接
     *
     * @param $dbname 数据库
     * @param $host host
     * @param $port 端口
     * @param $db_user 用户名
     * @param $db_pwd 密码
     * @param $charset 编码
     * @return Mysqli|null
     */
    public static function getInstance($dbname, $host, $port,$db_user, $db_pwd, $charset)
    {
        if(!self::$_instance){
            self::$_instance = new self($dbname, $host, $port,$db_user, $db_pwd, $charset);
        }
        return self::$_instance;
    }

    /**
     * 执行sql语句 select
     *
     * @param $strSql
     * @param string $mode
     * @return array|bool|int|\mysqli_result|null
     */
    function query($strSql, $mode = "array")
    {
        $strSql = trim($strSql);
        if($strSql==""){
            DYBaseFunc::showErrors("Query cannot be empty!");
        }
        $query = mysqli_query($this->db, $strSql);
        if(!$query){
            $this->showMysqliError();
        }
        if (strpos(strtolower($strSql), "select") ===false) {
            return $query;
        }

        switch ($mode) {
            case 'array' :
                $res = mysqli_fetch_all($query, MYSQLI_ASSOC);
                break;
            case 'object' :
                $res = array();
                while($r = mysqli_fetch_object($query)){
                    $res[] = $r;
                }
                break;
            case 'count':
                $res = mysqli_num_rows($query);
                break;
            default:
                DYBaseFunc::showErrors("SQLERROR: please check your second param!");
        }
        return $res;
    }

    /**
     * 插入语句
     *
     * @param $table 表名
     * @param $arrayDataValue 数据
     * @param bool|true $escape 是否转义
     * @return bool|\mysqli_result
     */
    function insert($table, $arrayDataValue, $escape = true)
    {
        $this->checkFields($table, array_keys($arrayDataValue));
        if($escape)
        {
            $arrayDataValue  = $this->addEscape($arrayDataValue);
        }
        $strSql = "INSERT INTO `$table` (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
        $result = mysqli_query($this->db, $strSql);
        if(!$result){
            $this->showMysqliError();
        }
        return $result;
    }

    function update($table, $arrayDataValue, $where, $escape)
    {
        // TODO: Implement update() method.
    }

    function delete($table, $where)
    {
        // TODO: Implement delete() method.
    }

    /**
     * 获得数据表中所有列名
     *
     * @param $table
     * @return array
     */
    function getColumns($table)
    {
        $fields = array();
        $query = mysqli_query($this->db, "SHOW COLUMNS FROM $table");
        if(!$query){
            $this->showMysqliError();
        }
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        foreach ($result as $rows) {
            $fields[] = $rows['Field'];
        }
        return $fields;
    }

    function showMysqliError()
    {
        DYBaseFunc::showErrors("错误代码：".mysqli_errno($this->db)." ERROR : ".mysqli_error($this->db));
    }

    /**
     * 转义
     *
     * @param $arrayDataValue
     * @return array
     */
    private function addEscape($arrayDataValue){
        $arr = array();
        foreach($arrayDataValue as $key => $value)
        {
            $arr[$key] = addslashes($value);
        }
        return $arr;
    }

    /**
     * 检查栏目名字是否正确
     *
     * @param $table
     * @param $array
     */
    private function checkFields($table, $array)
    {
        $fields = $this->getColumns($table);
        foreach($array as $key){
            if(!in_array($key, $fields)){
                DYBaseFunc::showErrors("SQLERROR : Unknown column `$key` in field list.");
            }
        }
    }
}