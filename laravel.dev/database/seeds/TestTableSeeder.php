<?php

use Illuminate\Database\Seeder;

// 1. 引入ＤＢ类　空间类元素的引入
use Illuminate\Support\Facades\DB;
class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 2. 测试数据的模拟
        $insertData = [
        	'username' => 'caoyang',
        	'phoneNumber' => '12345678909',
        	'updated_at' => date('Y-m-d H:i:s'), // 不是时间戳 是一个格式的字符串 
        	'created_at' => date('Y-m-d H:i:s'), // 不是时间戳 是一个格式的字符串 
        ];
        // DB 类是Laravel里面提供的 如果要直接使用，则需要先还引入
    	DB::table('dbtest')->insert($insertData);

    }
}
