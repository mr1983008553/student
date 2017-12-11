<?php
//设置命名空间 用于以后的调用
namespace houdunwang\model;

class Model
{
//    设置公共功能__call
    public function __call ( $name , $arguments )
    {
//        将结果即取出来
        return self ::runParse ( $name , $arguments );
    }

//设置公共静态函数__callstatic
    public static function __callStatic ( $name , $arguments )
    {
        return self ::runParse ( $name , $arguments );
    }

//设置公共静态函数runParse
    public static function runParse ( $name , $arguments )
    {
        //p(get_called_class ());
        //获取当前调用的模型的名称，因为我们要使用其作为查询的数据表名
        $class = get_called_class ();
        //p($class);//system\model\Student
        return call_user_func_array ( [ new Base($class) , $name ] , $arguments );
    }
}
