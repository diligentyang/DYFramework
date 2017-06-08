<?php
namespace systems;

defined('ACCESS') OR exit('No direct script access allowed');

class DYController extends DYConModBase
{

    static private $_classes = array();

    /**
     * DYController constructor.
     */
    function __construct()
    {

    }

    /**
     * Include Model
     *
     * @param string $model Model name
     *
     * @return mixed
     */
    public function model($modelname)
    {
        $model = "models\\".$modelname;
        if(!$this->getClass($model))
        {
            $this->setClass($model, new $model());
        }
        return $this->getClass($model);
    }

    /**
     * Include view
     *
     * @param string $viewpath View path
     * @param array  $data     Data
     *
     * @return null
     */
    function view($viewpath, $data = array())
    {
        extract($data);//该函数使用数组键名作为变量名，使用数组键值作为变量值。针对数组中的每个元素，将在当前符号表中创建对应的一个变量。
        $viewpath = trim($viewpath);
        $viewpath = BASE_PATH . "views" . DS . $viewpath;
        if (is_file($viewpath . ".html")) {
            include($viewpath . ".html");
        } else if (is_file($viewpath . ".htm")) {
            include($viewpath . ".htm");
        } else if (is_file($viewpath . ".php")) {
            include($viewpath . ".php");
        } else {
            DYBaseFunc::showErrors("Only .php|.html|.htm can be viewed and please check your view path");
        }
    }

    function RenderView($view = null, $data = null){
        if($view == null){
            DYBaseFunc::showErrors("Only .php|.html|.htm can be viewed and please check your view path");
        }
        $path = [BASE_PATH.'views'];         // 视图文件目录，这是数组，可以有多个目录
        $cachePath = BASE_PATH.'cache';     // 编译文件缓存目录
        $compiler = new \Xiaoler\Blade\Compilers\BladeCompiler($cachePath);
        // 如过有需要，你可以添加自定义关键字
        $compiler->directive('datetime', function($timestamp) {
            return preg_replace('/(\(\d+\))/', '<?php echo date("Y-m-d H:i:s", $1); ?>', $timestamp);
        });
        $engine = new \Xiaoler\Blade\Engines\CompilerEngine($compiler);
        $finder = new \Xiaoler\Blade\FileViewFinder($path);
        // 如果需要添加自定义的文件扩展，使用以下方法
        //$finder->addExtension('tpl');
        $factory = new \Xiaoler\Blade\Factory($engine, $finder);
        echo $factory->make($view, $data)->render();
    }

    /**
     * Set class into $_classes
     *
     * @param string $class Model class name
     * @param object $val   Model object
     *
     * @return null
     */
    private function setClass($class, $val)
    {
        if (!$this->getClass($class)) {
            self::$_classes[$class] = $val;
        }
    }

    /**
     * Get Class or not
     *
     * @param string $class Class name
     *
     * @return mixed
     */
    private function getClass($class)
    {
        return isset(self::$_classes[$class]) ? self::$_classes[$class] : null;
    }

}