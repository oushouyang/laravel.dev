<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>layer添加用户</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/admin/css/mine.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/swal/sweetalert.css"/>
        <script type="text/javascript" src='/swal/sweetalert.min.js'></script>
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：用户管理-》layer添加用户信息</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="{{ url('user/lst') }}">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>


        <div style="font-size: 13px;margin: 10px 5px">
            <form action="{{ url('admin/user/add') }}" method="POST" enctype="multipart/form-data">
            <table border="1" width="100%" class="table_a">
                <!--为了防止 csrf攻击 外站提交-->
                {{ csrf_field() }}

                <tr>
                    <td>用户名</td>
                    <td><input type="text" name="username" /></td>
                </tr>
                <tr>
                    <td>图片</td>
                    <td><input type="file" name="pic" /></td>
                </tr>
               
                <tr>
                    <td>密码</td>
                    <td><input type="password" name="password" /></td>
                </tr>

                <tr>
                    <td>邮箱</td>
                    <td><input type="text" name="email" /></td>
                </tr>

                <tr>
                    <td>手机号码</td>
                    <td><input type="text" name="phoneNumber" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="layer添加">
                    </td>
                </tr>  
            </table>
            </form>
        </div>
    </body>

</html>

<div class="error-contaier">
    <!--1. 先将所有的错误信息保存起来，放在一个变量里面  2. 使用sl进行弹出-->
    <?php
    // 会自动的把错误的信息保存在一个$errors变量里面
    if(count($errors) > 0){
        $errorString = ''; // 所有的错误信息
        foreach($errors->all() as $error){
            $errorString .= $error . '<br/>';
        }

    }
    ?>
    @if(isset($errorString))
        <script type="text/javascript">
            swal({
                title: "提示信息!",
                html: true, // 注意：可能产生xss
                text: "{!!  $errorString !!}",
                type: "error",
                confirmButtonText: "error"
            });
        </script>
    @endif
</div>
