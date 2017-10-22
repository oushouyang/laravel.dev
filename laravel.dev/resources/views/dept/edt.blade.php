<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>编辑用户</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/admin/css/mine.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/swal/sweetalert.css"/>
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：用户管理-》编辑用户信息</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./admin.php?c=goods&a=showlist">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>

        <div style="font-size: 13px;margin: 10px 5px">
            <form action="{{ url('admin/user/edt') }}" method="POST" enctype="multipart/form-data">
            <table border="1" width="100%" class="table_a">
                <!--1. 为了防止 csrf攻击 外站提交-->
                {{ csrf_field() }}
                <!-- 更新条件 -->
                <input type="hidden" name="id" value="{{ $userInfo->id }}">

                <tr>
                    <td>用户名</td>
                    <td><input type="text" name="username" value="{{ $userInfo->username }}" /></td>
                </tr>
               
                <tr>
                    <td>密码</td>
                    <td>
                        <input type="password" name="password"  /> <font color="red">*留空代表不修改</font>
                    </td>
                </tr>

                <tr>
                    <td>邮箱</td>
                    <td><input type="text" name="email"  value="{{ $userInfo->email }}"  /></td>
                </tr>

                <tr>
                    <td>手机号码</td>
                    <td><input type="text" name="phoneNumber"  value="{{ $userInfo->phoneNumber }}"  /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="编辑">
                    </td>
                </tr>  
            </table>
            </form>
        </div>
    </body>
    <script type="text/javascript" src='/swal/sweetalert.min.js'></script>
</html>
<!-- 需要在这里引入如下的信息 blade标签语法-->
@if (Session::has('sweet_alert.alert'))
    <script>
        swal({!! Session::get('sweet_alert.alert') !!});
    </script>
@endif

