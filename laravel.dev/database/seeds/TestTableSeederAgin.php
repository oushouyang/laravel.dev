<?php
use Illuminate\Database\Seeder;
// 1. 引入ＤＢ类　空间类元素的引入
use Illuminate\Support\Facades\DB;

class TestTableSeederAgin extends Seeder
{
 
    public function run()
    {
    	// 2. 获取faker的实例 代表是中文测试数据
    	$faker = Faker\Factory::create('zh_CN');
    	// 3. faker下存在很多的属性可以使用

    	for ($i=0; $i < 1000; $i++) { 

	        // 2. 测试数据的模拟
	        $insertData = [
	        	'username' => $faker->name,
	        	'phoneNumber' => $faker->phoneNumber,
	        	'updated_at' => $faker->date('Y-m-d H:i:s'), // 不是时间戳 是一个格式的字符串 
	        	'created_at' => $faker->date('Y-m-d H:i:s'), // 不是时间戳 是一个格式的字符串 
	        ];
	        // DB 类是Laravel里面提供的 如果要直接使用，则需要先还引入
	    	DB::table('dbtest')->insert($insertData);
    	}

    }
}
