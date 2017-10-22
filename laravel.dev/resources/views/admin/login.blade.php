<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content="MSHTML 6.00.6000.16674" name="GENERATOR" />

        <title>用户登录</title>

        <link href="/admin/css/User_Login.css" type="text/css" rel="stylesheet" />
        <link href="/swal/sweetalert.css" type="text/css" rel="stylesheet" />
    </head><body id="userlogin_body">
        <div></div>
        <div id="user_login">
            <dl>
                <dd id="user_top">
                    <ul>
                        <li class="user_top_l"></li>
                        <li class="user_top_c"></li>
                        <li class="user_top_r"></li></ul>
                </dd><dd id="user_main">
                <!-- 在laravel里面的URL地址的生成 不能使用 TP类似的U 但是存在 url(路由规则)函数-->
                <!-- 1. 展示  和 收集同一个方法方法里面完成-->
                    <form action="{{ url('admin/login') }}" method="POST">
                    <!--为了防止csrf攻击： 作用：1. 先生成一个随机字符串 隐藏域 2. 在session放一份-->
						{{ csrf_field() }}
                        <ul>
                            <li class="user_main_l"></li>
                            <li class="user_main_c">
                                <div class="user_main_box">
                                    <ul>
                                        <li class="user_main_text">用户名： </li>
                                        <li class="user_main_input">
                                            <input class="TxtUserNameCssClass" id="admin_user" maxlength="20" name="username"> </li></ul>
                                    <ul>
                                        <li class="user_main_text">密&nbsp;&nbsp;&nbsp;&nbsp;码： </li>
                                        <li class="user_main_input">
                                            <input class="TxtPasswordCssClass" id="admin_psd" name="password" type="password">
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="user_main_text">验证码： </li>
                                        <li class="user_main_input">
                                            <input class="TxtValidateCodeCssClass" id="captcha" name="captcha" type="text">
                                            <img src="{{ url('admin/code') }}"  onclick="this.src='{{ url('admin/code') }}/' + Math.random();" alt="" />
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="user_main_r">

                                <input style="border: medium none; background: url('/admin/img/user_botton.gif') repeat-x scroll left top transparent; height: 122px; width: 111px; display: block; cursor: pointer;" value="" type="submit">
                            </li>
                        </ul>
                    </form>
                </dd><dd id="user_bottom">
                    <ul>
                        <li class="user_bottom_l"></li>
                        <li class="user_bottom_c"><span style="margin-top: 40px;"></span> </li>
                        <li class="user_bottom_r"></li></ul></dd></dl></div><span id="ValrUserName" style="display: none; color: red;"></span><span id="ValrPassword" style="display: none; color: red;"></span><span id="ValrValidateCode" style="display: none; color: red;"></span>
        <div id="ValidationSummary1" style="display: none; color: red;"></div>
    </body>
    <script type="text/javascript" src='/swal/sweetalert.min.js'></script>
    <script type="text/javascript">
    	//1. 标题 2. 内容 3. 不用的样式 
    	// swal('Lorem ipsum dolor sit.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi, non?', 'success');
    </script>
</html>
<!-- 需要在这里引入如下的信息 blade标签语法-->
@if (Session::has('sweet_alert.alert'))
    <script>
        swal({!! Session::get('sweet_alert.alert') !!});
    </script>
@endif
