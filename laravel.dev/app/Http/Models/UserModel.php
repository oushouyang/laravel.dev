<?php
// 1. 命名空间
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    // 2. 定义如下的四个属性
    protected $table = 'user';
    protected $primaryKey = 'id'; // 默认是ID则不需要指出，建议写上
    // 代表是否开启 created_at 和 updated_at 的处理机制，如果开启了则laravel自动的处理这两个字段
    public $timestamps = true;  // 访问的权限必须是 public
    // 允许插入的字段
    protected $fillable = ['username', 'password', 'email', 'phoneNumber']; // 主键ID created_at updated_at 不用写


}
