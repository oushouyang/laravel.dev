<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     * 主要是用来生成数据表
     * @return void
     */
    public function up()
    {
        // 代表可以表 第一参数 表名 
        // 函数：当up调用的时候，该函数执行，并且函数的参数 $table 类型 Blueprint
        Schema::create('dbtest', function (Blueprint $table) {
            $table->increments('id'); // 主键
            // username 用户名
            $table->string('username', 30)->notNull()->default('');
            // phoneNumber 手机号码
            $table->string('phoneNumber', 20)->notNull()->default('');

            // 注意：一般laravel里面会为没张表生成额外的两个字段 created_at updated_at
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     * 删除表
     * @return void
     */
    public function down()
    {
        // 表存在，则删除
        Schema::dropIfExists('dbtest');
    }
}
