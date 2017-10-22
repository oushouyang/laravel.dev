<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');

            // 用户名 密码 邮箱 手机号码
            $table->string('username', 30)->notNull(); // 必须填写的
            $table->char('password', 32)->notNull();
            $table->string('email', 50)->notNull();
            // 手机号码的字段一般都是设计至少15位（国际项目）
            $table->string('phoneNumber', 20)->notNull();

            $table->timestamps();
            // 2017-12-11 8:9:9
            // $table->timestamp('created_at'); 等同于数据库中的DATE类型 
            // $table->timestamp('updated_at'); 等同于数据库中的DATE类型 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop 如果有的时候手工的在数据库里面做了删除
        // Schema::drop('user');
        Schema::dropIfExists('user'); // 安全
    }
}
