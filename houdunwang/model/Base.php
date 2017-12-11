<?php
//设置命名空间 用于以后的调用
namespace houdunwang\model;

//从全局空间，引入Exception
use Exception;
use PDO;

class Base
{
//    创建$pdo共用方法  能保存初始值
    private static $pdo = null;
//     操作数据表 建私有属性$table,来操作数据表
    protected $table;
//    sql语句where条件
    protected $where;
//    指定查询的字段  定义私有属性,看查询字段是否传过来了，没有就默认是空字符串
    protected $field = '';
//    排序
    protected $order;

//用形参来接收，来自Student页面，传过来的数据
    public function __construct($class)
    {
        //首先获取数据表名
        $info = explode('\\', $class);

//        打印测试
//        p ($info);die;

        $this->table = strtolower($info[2]);
        //1.连接数据库
        //        if判断
        //        判断$pdo的值是否是空,是空执行if里面的语句，不是空着跳过if语句
        if (is_null(self::$pdo)) {
            $this->connect();
        }
    }

    /**
     * 连接数据库
     */
    private function connect()
    {
        try {
//            从c函数哪返回的值，就是连接数据库初始的值,到houdunwang的view,Base文件处理稳健后缀名的问题
            //连接信息：驱动：mysql、主机地址：host、数据库名：dbname
//            加载配置项  这里如果不写c那么就不能加载配置项文件
            $dsn = c('database.driver') . ":host=" . c('database.host') . ";dbname=" .
                c('database.dbname');
//            加载配置项用户名
//            数据库用户名
            $user = c('database.user');
//            加载配置项用户名密码
//            数据库用户名密码
            $password = c('database.password');
            self::$pdo = new PDO($dsn, $user, $password);
            //设置字符集 用c函数那是要加进配置项里面，给用的人进行更改的,去到system的config里面
            self::$pdo->query('set names ' . c('database.charset'));
            //设置错误属性
//            抛出异常
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 根据主键获取数据库单一一条数据
     *
     * @param $pk    主键值
     *
     * @return mixed
     */
    public function find($pk)
    {
        //p($this->table);
        //获取查询数据表的主键
        $priKey = $this->getPriKey();
        $this->field = $this->field ?: '*';
        //$sql = "select * from student where id=1";
        $sql = "select {$this->field} from {$this->table} where {$priKey}={$pk}";
        $res = $this->q($sql);

        return current($res);
    }

    /**
     * 查询单一一条数据
     *
     * @return mixed
     */
    public function first()
    {
//        组合查询字段
        //$sql = "select * from student where name='小红'";
//        在这里需要注意如果没有传参数默认为*
//        判断  三元表达式  如果成立取他自己本身  不成立就取*  这里的* 是一个空字符串
        $this->field = $this->field ?: '*';
//        分装函数之后把所有的* 替换为$this->field
        $sql = "select {$this->field} from {$this->table} {$this->where}";
//        将拼凑好的sql语句写进数据库
        $data = $this->q($sql);
        //p($data);
        //        这时候打印出来的数据是一个二维数组
        return current($data);
    }


    /**
     * 按条件查找进行排序
     * @param $order
     * @return $this
     *
     */
    public function order($order)
    {
//        p($order);die;
//        打印结果age desc
//    先创建order属性
//        $sql="select * from student where age>20 order by age desc";
//    首先用explode函数，将$order进行分割成数组  因为要将获取的数组进行排序、
        $order = explode(',', $order);
//    p ($this->order);die;
        $this->order = 'order by ' . $order[0] . " $order[1]";
//    返回对象，链式操作
        return $this;
    }

    /**
     * 查找指定列的字段
     * @param $field    字段名称
     *
     * @return $this
     */
    public function field($field)
    {
        //p ( $field );//name,sex
//        将从app  index页面传出来的字段，赋值给属性值
        $this->field = $field;
//返回this 这个类
        return $this;
    }

    /**
     * sql语句中where条件
     *
     * @param $where
     *
     * @return $this
     */
    public function where($where)
    {
//        p($where);
//      拼接查询语句  需要在where后面加上空格
        $this->where = 'where ' . $where;
//        返回对象，进行链式操作,去到app的index页面
        return $this;
    }

    /**
     * 获取数据表中所有数据
     *
     * @return mixed    所有数据数组
     */
    public function getAll()
    {
        //$this->field  = $this->field ? $this->field : '*';
        $this->field = $this->field ?: '*';
        //        判断  三元表达式  如果成立取他自己本身  不成立就取*  这里的* 是一个空字符串
        //$sql = "select * from student";
//        分装函数之后吧所有的* 替换为$this->field

        //拼接语句，像数据库中写入语句
        //对getAll进行进一步的拼接
        $sql = "select {$this->field} from {$this -> table}  {$this->where} {$this->order}";

        //p($sql);die;
        return $this->q($sql);
    }

    /**
     * 获取数据表中主键的名称
     *
     * @return mixed    主键名称
     */
    public function getPriKey()
    {
        $sql = "desc {$this->table}";
        $res = $this->q($sql);
        //p($res);//这里一定要打印看数据
        foreach ($res as $k => $v) {
            if ($v['Key'] == 'PRI') {
                $priKey = $v['Field'];
                break;
            }
        }

        return $priKey;
    }

    /**
     * 更新数据
     * @param $data    要更新的数组数据
     *
     * @return bool
     */
    public function update($data)
    {
        //判断如果没有where条件不允许更新 不继续运行并返回null
        if (!$this->where) {
            return false;
        }
//        定义一个空字符串，用来进行连接的作用
        $set = '';
//        遍历index页面传过来的数据
        foreach ($data as $k => $v) {
            if (is_int($v)) {
//                如果是int类型就不用加引号
                $set .= $k . '=' . $v . ',';
            } else {
//                否则就要加双引号  因为单引号不解析变量
                $set .= $k . '=' . "'$v'" . ',';
            }
        }
//        连接完的字符串，在最后会多出来一个逗号  这里要去除最右侧的逗号
        $set = rtrim($set, ',');
        //p($set);die;
        //sql = "update student set sname='',age=19,sex='男' where id=1"（where更新的条件）;
//                            数据表
        $sql = "update {$this->table} set {$set} {$this->where}";
//        将拼接好的更新语句用e方法写进数据库中去,并把结果进行返回
        return $this->e($sql);
    }

    /**
     *删除
     * @param $data    要删除的数组数据
     *
     */
    public function delete()
    {
        //判断如果没有where条件不允许更新 返回null
        if (!$this->where) {
            return false;
        }
        //$sql = "delete from student where id=1";
//        拼接sql语句
//                                数据表       where条件
        $sql = "delete from {$this->table} {$this->where}";
        return $this->e($sql);
    }

    /**
     * 数据表写入数据
     * @param $data
     *
     * @return mixed
     */
    public function insert($data)
    {
//        定义$field和$value这两个insert方法里面的变量,后面还用到foreach操作$data的数据
        //p($data);die;
//        定义一个空字符串 用来接收最后的结果数据
        $field = '';
//        用来存后面写入数据的值
        $value = '';
        foreach ($data as $k => $v) {
            $field .= $k . ',';
//            判断键值
            if (is_int($v)) {
//                如果是整形就不加引号  如果不是就要加引号
                $value .= $v . ',';
            } else {
//                需要注意要加双引号 因为单引号不解析变量
                $value .= "'$v'" . ',';
            }
        }
//        把最右侧的逗号去掉
        $field = rtrim($field, ',');
        //p($field);die;
        $value = rtrim($value, ',');
        //p($value);die;
        //$sql = "insert into student (age,name,sex,cid) values (22,李强','男',1)";
//                               数据表
        $sql = "insert into {$this->table} ({$field}) values ({$value})";
        //p($sql);die;
//        这时候会返回受影响的条数
        return $this->e($sql);
    }

    //执行有结果集的查询
    //select
    public function q($sql)
    {
        try {
            //执行sql语句
            $res = self::$pdo->query($sql);

            //将结果集取出来
            return $res->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    //执行无结果集的sql
    //insert、update、delete
    public function e($sql)
    {
        try {
            return self::$pdo->exec($sql);
        } catch (Exception $e) {
            //输出错误消息
            die($e->getMessage());
        }
    }
}