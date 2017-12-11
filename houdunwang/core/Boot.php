<?php
//设置命名空间 用于以后的调用
namespace houdunwang\core;

use app\home\controller\Index;

/**
 * 启动类
 * Class Boot
 *
 * @package houdunwang\core
 */


//创建类 把一些常用的，复杂的过程封装进去
//在使用的时候简单调用就完成
class Boot
{
//    创建静态方法
//静态方法可以通过类名直接调用，而不需要实例化类的对象。
//这样在工具类里声明静态方法，用起来就比较方便。
    public static function run()
    {
//      处理错误
        self::handler();
//		1.测试程序能否正常运行到这里
//        echo 'run';
//		1.在浏览器里输出echo 'run'测试Boot.php是否可以通过composer自动加载

//        将助手函数放在system/helper中
//		2.如果程序正常运行到这里，处理助手函数的加载

//		3.加载完助手函数库开始执行初始化的动作
//        self::init();

//		4.在app/home/controller创建类文件Index.php
//                      然后应用app里面的类库

//		然后测试Index.php类是否能加载到
//        通过?s=模块/控制器/方法  (?s=home/Index/index) 这里用get参数控制访问
//?s=home/article/add;
        //1.执行初始化的动作
        self ::init ();
        //执行应用
        self::appRun();
    }

    //错误异常处理
    public static function handler(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    public static function appRun(){
//        ?c=Index&a=index&m=home
//        开始if判断 $_GET是否有参数
            if (isset($_GET['s'])) {
                //地址栏测试地址：?s=home/article/index   (模块/控制器/方法)
                $s = $_GET['s'];
                //p($_GET['s']);die;
                //为了获取路径 需要将$s转为数组
                $info = explode('/', $s);
                //p($info);die;
//            创建变量 用来获取数组中的第一个参数
                $m = $info[0];//模块
                $c = ucfirst($info[1]);//控制器类
                $a = $info[2];//方法
            } else {
                //当地址栏没有参数的时候 需要给默认值
//            变量是一个可以存储值的字母或名称在这里需要创建变量 用来让他们的默认参数成为所赋的值
//            模块
                $m = 'home';
//            控制器类
                $c = 'Index';
//            方法
                $a = 'index';
            }
//		定义常量,因为define定义的常量可以不受命名空间限制

//        创建常量并赋值
//        因为在其他类里使用的话组合路径当做全局变量使用
            define('MODULE', $m);
            define('CONTROLLER', $c);
            define('ACTION', $a);
//		闭合路径


            $controller = "\app\\{$m}\controller\\{$c}";
            //new $controller这个类，调用$a,并且把该函数的第二个参数作为$a方法的参数
            echo call_user_func_array([new $controller, $a], []);
        }

    /**
     * 初始化框架
     */
    public static function init ()
    {
        //1.头部
        header ( 'Content-type:text/html;charset=utf8' );
        //2.设置时区
        date_default_timezone_set ( 'PRC' );
        //3.开启session
        //如果已经有session_id()说明session开启过了
        //如果没有session_id，则再开启session
        //重复开启session，会导致报错
        session_id () || session_start ();
    }
}
