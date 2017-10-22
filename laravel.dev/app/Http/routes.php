<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/**
 * 第一个参数代表是URL地址除开域名之外的部分
 * http://laravel51.dev/
 *
 * 第二个参数代表是当用户进行请求后，第二个参数如果是一个匿名函数（PHP里面被称为闭包），则会自动的被调用，该函数的返回值做http的响应，然后返回给浏览器
 */
Route::get('/', function () {
	// 这里有一个 view() 函数，该函数是用来做视图的载入的。
	return 'hi !!!!';
    // return view('welcome');
});
// 当用户访问形如这样的 http://laravel51.dev/test 地址，则匿名函数会执行
Route::get('/test', function () {
	return 'test call.....';
});

Route::get('/user/login', function () {
	// views/admin/login.blade.php文件
	// 注意：默认是要的 / 作为目录的分隔符， 但是有时候也使用 . 作为目录的分隔符
	// return view('admin/login');
	// .......... 业务逻辑
	return view('admin.login');
});

// ctrl + p 去全局搜索 ctrl + p

// 定义规则，当用户请求某个URL的时候，交给UserController控制器的lst方法
// http://laravel51.dev/user/lst
Route::get('/user/lst', 'Admin\UserController@lst');
Route::get('/user/add', 'Admin\UserController@add');

Route::get('/test/lst', 'Admin\TestController@lst');
// DB类使用
Route::get('/test/test', 'Admin\TestController@test');

// 登录表单
Route::match(['get', 'post'], 'admin/login', 'Admin\AdminController@login');
// 生成验证码 {number?} 代表这个参数是可有可无的
Route::get('admin/code/{number?}', 'Admin\AdminController@code');


// 代表是把整个后台需要登录的部分，分成一个小组
// 方式二：分组处理
Route::group(['middleware' => 'admin.login'], function() {
	Route::get('/admin/logout', function()
	{
		// 1. 清空
		session()->flush();
		// 2. 回跳
		return redirect('admin/login');

	});

	// 注意：如果我们只是单纯的展示一个视图页面，则完全没有必要写一个控制器文件，则全部可以在路由规则的匿名函数里面直接使用view函数进行载入
	Route::get('/admin/index', function() {
	    return view('admin.index');
	});


	Route::get('/index/head', function() {
	    return view('admin.head');
	});

	Route::get('/index/left', function() {
	    return view('admin.left');
	});
	Route::get('/index/right', function() {
	    return view('admin.right');
	});


	// 定义user的curd操作
	// 添加的表单
	Route::match(['get', 'post'], '/admin/user/add', 'Admin\UserController@add');

	// 展示
	Route::get('/admin/user/lst', 'Admin\UserController@lst');

	// 删除 {id} 代表是URL里面的参数 到时候在控制器的方法里面只能写 $id 参数绑定
	// {id?} 代表是可选？
	Route::get('/admin/user/del/{id?}', 'Admin\UserController@del')->where('id', '[0-9]+');

	// 编辑
	Route::get('/admin/user/edt/{id?}', 'Admin\UserController@edt');

	Route::post('/admin/user/edt', 'Admin\UserController@edt');

//    使用datatable的ajax模式获取数据
    Route::post('user/ajaxData', 'Admin\UserController@ajaxData');
//    datatable删除
    Route::post('/admin/user/ajaxDel', 'Admin\UserController@ajaxDel');

//    layer添加
    Route::get('/admin/user/layeradd', 'Admin\UserController@layeradd');



    // 定义dept的curd操作
    // 添加的表单
    Route::match(['get', 'post'], '/admin/dept/add', 'Admin\DeptController@add');

    // 展示
    Route::get('/admin/dept/lst', 'Admin\DeptController@lst');



});

Route::get('/admin/user/test', 'Admin\UserController@test');




