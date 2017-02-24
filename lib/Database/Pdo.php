<?php
namespace lib\Database;
use \systems\DYBaseFunc as DYBaseFunc;

class Pdo implements IDataBase
{
    private static $_instance = null;
    private $db;

    /**
     * Pdo constructor.
     * @param $dbname
     * @param $host
     * @param $db_user
     * @param $db_pwd
     * @param $charset
     */
    private function __construct($dbname, $host, $port,$db_user, $db_pwd, $charset)
    {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->db = new \PDO($dsn, $db_user, $db_pwd);
        } catch (\PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
            exit();
        }
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->exec("set names $charset");
    }

    /**
     * 获取PDO连接
     *
     * @param $dbname 数据库名称
     * @param $host host
     * @param $db_user 用户名
     * @param $db_pwd 密码
     * @param $charset 编码
     * @return Pdo|null
     */
    public static function getInstance($dbname, $host, $port,$db_user, $db_pwd, $charset)
    {
        if(!self::$_instance){
            self::$_instance = new self($dbname, $host, $port,$db_user, $db_pwd, $charset);
        }
        return self::$_instance;
    }

    /**
     * 执行SQL查询语句，或简单执行其他语句
     *
     * @param $strSql sql语句
     * @param string $mode 返回类型
     * @return array|int|\PDOStatement
     */
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
     * 插入语句
     *
     * @param $table 表名字
     * @param $arrayDataValue 数组
     * @param bool|false $escape 是否转义
     * @return int 返回影响行数
     */
    function insert($table, $arrayDataValue, $escape = true)
    {
        $this->checkFields($table, array_keys($arrayDataValue));
        if($escape)
        {
            $arrayDataValue  = $this->addEscape($arrayDataValue);
        }
        $strSql = "INSERT INTO `$table` (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
        $result = $this->db->exec($strSql);
        $this->getPDOError();
        return $result;
    }

    /**
     * 更新操作
     *
     * @param $table 表名字
     * @param $arrayDataValue 数组
     * @param string $where 条件
     * @param bool|true $escape 是否转义
     * @return int 影响行数
     */
    function update($table, $arrayDataValue, $where = '', $escape = true)
    {
        if($where){
            $this->checkFields($table, array_keys($arrayDataValue));
            if($escape)
            {
                $arrayDataValue  = $this->addEscape($arrayDataValue);
            }
            $strSql = '';
            foreach ($arrayDataValue as $key => $value) {
                $strSql .= ", `$key`='$value'";
            }
            $strSql = substr($strSql, 1);
            $strSql = "UPDATE `$table` SET $strSql WHERE $where";
            $result = $this->db->exec($strSql);
            $this->getPDOError();
            return $result;
        }else{
            DYBaseFunc::showErrors("SQLERROR: Lack of update condition!");
        }
    }

    /**
     * 删除操作
     *
     * @param $table 表名
     * @param string $where 条件
     * @return int 影响行数
     */
    function delete($table, $where = "")
    {
        if ($where == '') {
            DYBaseFunc::showErrors("'WHERE' is Null");
        } else {
            $strSql = "DELETE FROM `$table` WHERE $where";
            $result = $this->db->exec($strSql);
            $this->getPDOError();
            return $result;
        }
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

    /**
     * 得到数据库中所有的栏目名字
     *
     * @param $table
     * @return array
     */
    function getColumns($table)
    {
        $fields = array();
        $recordset = $this->db->query("SHOW COLUMNS FROM $table");
        $this->getPDOError();
        $recordset->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $recordset->fetchAll();
        foreach ($result as $rows) {
            $fields[] = $rows['Field'];
        }
        return $fields;
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