<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
// Input 也在门面
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

// 引入加密类
use Illuminate\Support\Facades\Crypt;

// 弹窗
use Alert;

// 相对于index.php
require './code/Code.class.php';
class AdminController extends Controller
{
    public function login()
    {
        if( $_SERVER['REQUEST_METHOD'] == 'POST'){
            // 在laravel里面使用 Input类接收数据
            $username = Input::get('username');
            $password = Input::get('password');
            $captcha = strtoupper( Input::get('captcha') );
            // 验证码 1. 引入类文件
            $code = new \Code(); // 公共空间的元素
            $sessionCode = $code->get();
            if( $sessionCode != $captcha ){
                // 1 类文件使用
                // Alert::success('验证码不正确', '提示信息');

                // 2 助手函数
                // alert()->message('验证码不正确', '提示信息');
                alert()->error('验证码不正确', '提示信息')->autoclose(3500);
                return back(); // 验证码不正确
            }

            // 验证用户名信息 返回值是一个对象 oop
            $info = DB::table('user')->where('username', '=', $username)->first();
            if($info){
                // laravel的密码验证的思想是明文验证 不是密文（密文是会随机变化）
                if(  Crypt::decrypt($info->password)  == $password ){
                    // 成功 记录登录的标识 sesion();
                    session([
                            'id' => $info->id,
                            'uname' => $info->username,
                        ]);

                    return redirect('admin/index'); // 函数 主要是用作跳转
                }else{
                    Alert::error('密码不正确', '提示信息');
                    return back(); // back()是返回上一个页面 登录页面
                }
            }else{
                // 用户不存在
                Alert::error('用户不存在', '提示信息');
                return back(); // back()是返回上一个页面 登录页面
            }
        }
        return view('admin.login');
    }

    public function code()
    {
        // 验证码 1. 引入类文件
        $code = new \Code(); // 公共空间的元素
        $code->make(); // 生成
    }

}
