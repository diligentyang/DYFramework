<?php
namespace systems;

use yii\web\DbSession;

defined('ACCESS') OR exit('No direct script access allowed');

class Autoload
{
    /**
     * @var array 自动加载类
     */
    public static $classMap = array();
    /**
     * Auto loading
     *
     * @param string $fileName File name
     *
     * @return true of flase
     */
    static function loader($fileName)
    {
        if(isset(self::$classMap[$fileName])){
            return true;
        } else {
            $fileName = str_replace("\\", DS,$fileName);
            $file = BASE_PATH.$fileName.".php";
            if(is_file($file)){
                include $file;
                self::$classMap[$fileName] = $fileName;
            }else{
                ;echo "请检查所引用类".$fileName."的命名空间是否正确";exit();
            }
        }
    }
}




