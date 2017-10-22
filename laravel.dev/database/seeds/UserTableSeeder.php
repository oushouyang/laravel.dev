<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        // 测试数据（laravel 先有数据 在完成功能） 先做添加 在做展示
        // faker
        $faker = Faker\Factory::create('zh_CN'); // 属性 或者 方法
        // 香港 繁体
        for ($i=0; $i < 10; $i++) {
        	$data = [
        		'username' => $faker->name,
        		'password' => \Illuminate\Support\Facades\Crypt::encrypt('admin88'),
        		'email' => $faker->email,
        		'phoneNumber' => $faker->phoneNumber,
        		'updated_at' => $faker->date('Y-m-d H:i:s'),
        		'created_at' => $faker->date('Y-m-d H:i:s'),
                'pic' => $faker->imageUrl(300, 200), // 生成图片
        	];
        	// 入库
        	DB::table('user')->insert($data);
        }
    }
}
