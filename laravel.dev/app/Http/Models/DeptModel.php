<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DeptModel extends Model
{
    //    手工建表
    // 1. 定义如下的四个属性
    protected $table = 'dept';
    protected $primaryKey = 'id'; // 默认是ID则不需要指出，建议写上
    // 代表是否开启 created_at 和 updated_at 的处理机制，如果开启了则laravel自动的处理这两个字段
    public $timestamps = false;  // 访问的权限必须是 public
    // 允许插入的字段
    protected $fillable = ['dept_name', 'mark_up', 'pid']; // 主键ID created_at updated_at 不用写



    public function getTree()
    {
        $data = $this->all();
        // 递归处理
        return $this->_getTree($data);

    }
    private function _getTree($data, $pid = 0, $level = 0)
    {
        // 递归处理
        static $list = array();

        foreach($data as $k => $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;
                $list[] = $v;

                $this->_getTree($data, $v['id'], $level + 1);
            }
        }
        return $list;
    }

}
