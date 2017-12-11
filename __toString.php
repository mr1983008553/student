<?php
class IndexController
{
	public static function __callStatic ( $name , $arguments )
	{
		// TODO: Implement __callStatic() method.
		//echo $name;
		print_r ($arguments);
	}

	public function __call ( $name , $arguments )
	{
		// TODO: Implement __call() method.
		//echo $name;//add
		print_r ($arguments);
	}

	public function index(){
		echo 'index';
	}
}
//(new IndexController())->add(1,2);
//IndexController::add(1,2,3);


class View{
	public function with(){
		echo 'with';
		return $this;
	}
	public function make(){
		echo 'make';

	}
	//当输出一个对象的时候自动触发运行
	public function __toString ()
	{
		echo 111;
		//要求必须返回字符串
		return '';
	}
}
//new View();//页面上不会有输出
//echo (new View());//111
//这个时候with方法里面没有return $this这句话
//echo (new View())->with ();//with
//这个时候再with方法增加一个return $this;
//echo (new View())->with ();//with111







