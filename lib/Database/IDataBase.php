<?php

namespace lib\Database;
/**
 * Created by PhpStorm.
 * User: diligentyang
 * Date: 2017/2/23
 * Time: 20:58
 */
interface IDataBase
{
    function query($strSql, $mode);
    function getColumns($table);
    function insert($table, $arrayDataValue, $escape);
    function update($table, $arrayDataValue, $where, $escape);
    function delete($table, $where);
}