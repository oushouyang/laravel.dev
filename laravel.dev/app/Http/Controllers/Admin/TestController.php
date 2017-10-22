<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// 1. phpstorm则自动生成 记录命名空间 简化写法 建议
// use Illuminate\Support\Facades\DB;

// 2. 简化写法
use DB;

class TestController extends Controller
{
    public function lst()
    {
    	$title = "这是标题信息";
    	// 方式一：赋值 建议
    	// laravel 里面写数组 统一使用简洁语法 [] 
    	// 第二个参数：是一个关联数组，代表给视图的赋值
    	return view('test.lst', ['title' => $title]);
    	
    	// 方式二：赋值 不建议使用
    	// return view('test.lst')->with('title', $title);
    }

    /**
     * 完成DB类的： curd
     * @return [type] [description]
     */
    public function test()
    {

        // 1.DB::table('goods')->get()  获取所有的数据
        // 2.DB::table('goods')->where(条件)->get()
        // 3.DB::table('goods')->select(获取指定字段)->where(条件)->get()
        // 4.DB::table('goods')->where(条件)->first()

        // 语法 特点 如果是等于则 =可以不写
        $data = DB::table('dbtest')->where('id', '=', 5)->get();
        $data = DB::table('dbtest')->where('username', 'new Name')->get();
        dd($data);

        // select里面的参数是多个，每个代表是要获取的字段
        $data = DB::table('dbtest')->select('username', 'id')->where('id', '=', 5)->get();
        dd($data);

        // select里面的参数是一个数组，代表是要获取的字段信息
        $data = DB::table('dbtest')->select(['username', 'id'])->where('id', '=', 5)->get();
        dd($data);


        // DB::table('goods')->where(条件)->first() 获取单条信息
        $info = DB::table('dbtest')->select('id', 'username')->where('id', 5)->first();


        dd($info);




        // 1.DB::table('goods')->where(条件)->update(关联数组)
        // 语法： 返回值受影响的函数
        $rs = DB::table('dbtest')->where('id', '=', 5)->update([
                'username' => 'new Name',
                'phoneNumber' => '09876554321'
            ]);

        dd($rs);



        // 1.DB::table('goods')->where(字段，条件，值)->delete()

        // 语法： 返回值受影响的函数 id < 4 
        $rs = DB::table('dbtest')->where('id', '<', 4)->delete();
        dd($rs);



        // 1. 增加  返回值一个boolean
        // 1.DB::table('goods')->insert([一维关联数组])
        // 2.DB::table('goods')->insert([二维关联数组])

        // 获取主键
        // 3.DB::table('goods')->insertGetId([一维关联数组])

        $insertData = [
                'username' => 'caoyang' . mt_rand(100,20000),
                'phoneNumber' => '12345678909',
                'updated_at' => date('Y-m-d H:i:s'), // 到时候laravel会自动维护
                'created_at' => date('Y-m-d H:i:s'), // 到时候laravel会自动维护
        ];
        // $rs = DB::table('dbtest')->insert($insertData);
        $lastId = DB::table('dbtest')->insertGetId($insertData);

        dd($lastId); // var_dump() + die(); 






        
    }
}
