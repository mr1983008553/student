<?php
//设置命名空间 用于以后的调用
namespace app\home\controller;
//创建类 把一些常用的，复杂的过程封装进去
//在使用的时候简单调用就完成
class Article
{
    //创建相应的类的对象，这样就可以调用其中的方法
    public function index()
    {
        echo 'article';
    }

    public function add()
    {
        echo 'article add';
    }
}