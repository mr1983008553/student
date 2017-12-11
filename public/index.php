<?php
/**
 * 输入composer init初始化一个项目
 * 框架单一入口文件
 * 加载类库满足两个条件：1.include 2.use导入命名空间
 * Terminal执行命令：composer dump 自动生成vendor目录
 */

//加载vendor/autoload.php
require "../vendor/autoload.php";
//在这里需要注意  刷新浏览器是首先需要修改composer配置文件composer.json
//需要手动加入autoload
//然后在根目录下执行：composer dump

//调用启动类中run方法
\houdunwang\core\Boot::run();

