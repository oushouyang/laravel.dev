<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>layer添加部门</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/admin/css/mine.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/swal/sweetalert.css"/>
        <script type="text/javascript" src='/swal/sweetalert.min.js'></script>
    </head>

    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：部门管理-》layer添加部门信息</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="{{ url('user/lst') }}">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>


        <div style="font-size: 13px;margin: 10px 5px">
            <form action="{{ url('admin/dept/add') }}" method="POST" enctype="multipart/form-data">
            <table border="1" width="100%" class="table_a">
                <!--为了防止 csrf攻击 外站提交-->
                {{ csrf_field() }}

                <tr>
                    <td>部门名</td>
                    <td><input type="text" name="dept_name" /></td>
                </tr>

                <tr>
                    <td>上级部门</td>
                    <td>
                        <select name="pid" id="">
                            <option value="">请选择...</option>
                            <option value="0">顶级分类</option>
                            @foreach($deptData as $v)
                                <option value="{{ $v->id }}">{{ str_repeat('+', $v['level'] * 5) . $v->dept_name }}</option>
                            @endforeach

                        </select>
                    </td>
                </tr>


                <tr>
                    <td>备注信息</td>
                    <td>
                        <textarea name="mark_up" id="content" cols="50" rows="4"></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="添加">
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
