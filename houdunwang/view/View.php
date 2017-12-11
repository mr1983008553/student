<?php
//设置命名空间 用于以后的调用
namespace houdunwang\view;

//创建一个类View
class View
{
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
//        p($name);//make
//        p($arguments);
        return self::runParse($name, $arguments);
    }
//设置公共静态函数__callstatic
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        //p($arguments);die;
//        在_callStatic里面加内容,调用本类的runParse方法
        return self::runParse($name, $arguments);
    }
//写runParse方法,这个方法是_call和_callStatic和Base.php里面的类的连接点，也可以说是view类和Base类之间的中转站
    public static function runParse($name, $arguments)
    {
        //p($arguments);die;
        //(new Base)->$name($arguments);
        return call_user_func_array([new Base, $name], $arguments);
        }
    }