<?php
//设置命名空间 用于以后的调用
namespace app\home\controller;
use houdunwang\model\Model;
use houdunwang\core\Controller;
use system\model\Student;

//创建类 把一些常用的，复杂的过程封装进去
//在使用的时候简单调用就完成
class Index extends Controller
{

//创建相应的类的对象，这样就可以调用其中的方法
    public function index()
    {
        //echo 'index';
        //1.这时候需要在public/view文件夹中放入message.php模板文件
        /**
         * |--public
         * |--|--view   message.php
         */
        //2.在houdunwang/core/创建Controller.php类
        /**
         * |--houdunwang
         * |--|--core   Controller.php
         */
        //3.Index继承Controller类
        //$this->setRedirect ()->message('添加成功');
//        echo '首页';
        //p(u('member/index'));//?s=home/member/index
        //p(u('member'));//?s=home/Index/member
        //p(u('member/Entry/index'));//?s=member/Entry/index

//1.实例化类View,调用make方法
//        2.然后去View类里面找make方法
//    发现View中没有make方法  这时候会往根目录里寻找 触发_call方法
//        然后_call调用了View中的runParse方法

//        runParse实例化Base调用了make方法(new View())->make();


//        $a = 1;
//        $data = ['name' => '小青', 'age' => 23];
//查询指定列
//        $data = Student::where('age>30')->field("name,sex")->getAll();
//        p($data);

//        分配变量时使用conpact函数
        //p(compact ('data','a'));die;
//        把变量变成数组下标  变量值变成下标对应的值
        //return View::with();
//        return View::with(compact('data', 'a'))->make();
//        View::make()->with();


//            测试获取数据库所有数据
//        $data = Model::getAll();
//获取数据表所有数据
//        $res = Student::getAll();
//        p($res);

        //测试Model类中e和q方法是否有效
        //$res = Model::q('select * from student');
        //p($res);

//        测试配置项数据
//        $res=c('database');
//        p($res);

//          $res=c('database.driver');
//          p($res);


//        以下是打印测试
        /********测试模型中方法***********/
//       $res =Model::q('select * from student');
//       p($res);


        //根据主键查找数据库单一一个数据
        //获取学生表中id(主键)=1数据
//        $data = Student::find(1);
//        p($data);

        //$data = Student::field('age,sname')->find(1);
        //p($data);

        //根据其余字段(不是主键)查找某一条数据
        //$data = Student::where("sname='赵虎'")->first();
        //p($data);
        //查找年龄>30的同学
//			$data = Student::where("age>30 or sex='男'")->getAll();
//			p($data);


        //查询指定列
//       $data = Student::where('age>30')->field("name,sex")->getAll();
//        p($data);

        //排序
        $data = Student::where('age>20')->order('age,desc')->getAll();
        p($data);
    }


    public function add()
    {

        //$this->setRedirect ()->message('添加成功');

        //封装一个生成url的函数u

//        u('模块/控制器/方法')

        //$this->setRedirect ('?s=member/mine/index')->message('添加成功');
//        $this->setRedirect(u('article/add'))->message('添加成功');

        View::make();
    }
}