<?php
//设置命名空间 用于以后的调用
namespace houdunwang\view;

//创建一个类 Base;
class Base{
    //存储变量
    private $data = [];
    //模板文件
    private $file = '';
//    显示模板文件
    public function make(){
//        p(MODULE);
//        p(CONTROLLER);
//        p(ACTION);
        //include '../app/home/view/index/index.html';
        //include '../app/'.MODULE.'/view/'.strtolower (CONTROLLER).'/'.ACTION.'.php';
        $this->file =  '../app/'.MODULE.'/view/'.strtolower (CONTROLLER).'/'.ACTION.'.' . c('view.suffix');
        return $this;
    }

    /**
     * 分配变量，
     */
    public function with($var = []){
        //p($var);die;
        $this->data = $var;
        return $this;
    }

    public function __toString ()
    {
        //p($this->data);die;
        //将键名变为变量名字，将键值变为变量值

        extract ($this->data);
        //经过extract之后，会产生变量  至于产生的变量名字叫什么  就看调用with时候给的变量名字是什么
//        p($data)

        //加载模板文件
//        (with  make 都要调用  否则会报错)
        if($this->file){
            include $this->file;
        }
        return '';
    }
}