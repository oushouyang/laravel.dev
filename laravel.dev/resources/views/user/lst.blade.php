<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

    <title>会员列表</title>

    <link href="/admin/css/mine.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="/swal/sweetalert.css">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
    <!-- jQuery 必须要放在上面-->
    <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8"
            src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>

</head>
<body>
<style>
    .tr_color {
        background-color: #9F88FF
    }
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：商品管理-》商品列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="javascript:;" id="btn-add">【添加商品】</a>
                </span>
            </span>
</div>
<div></div>
<div class="div_search">
            <span>
                <form action="#" method="get">
                    起始：<input type="text" name="start" id="date-start" class="laydate-icon">
                    结束：<input type="text" name="end" id="date-end" class="laydate-icon">
                    名称：<input type="text" name="gn" value="" id="keyword">
                    <input value="查询" type="button" id="btn-search"/>
                </form>
            </span>
</div>
<div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" border="1" width="100%" id="data-table">
        <thead>
        <tr style="font-weight: bold;">
            <th><input type="checkbox" value="" id="delAll">全部删除</th>
            <th>序号</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>手机号</th>
            <th>更新时间</th>
            <th align="center">操作</th>
        </tr>
        </thead>

        <tbody>
            <!--datatable自动的填充初始化的数据-->
        </tbody>
    </table>
</div>
</body>
</html>
<script type="text/javascript" src="/laydate/laydate.js"></script>

<script type="text/javascript" src="/layer/layer.js"></script>
<script type="text/javascript" src="/swal/sweetalert.min.js"></script>

<script>
//layer.alert('提示信息');

</script>
<script type="text/javascript">
;(function(){
    var startAt = '';
    var endAt = '';
//    起始的时间
    laydate({
        elem: '#date-start',
        format: "YYYY-MM-DD hh:mm:ss",
        istime: true,
        // 当用户选择日期后会自动的调用
        // moment.js
        choose: function (date) {
//            判断一下结束时间是否存在,只有存在的情况下,才做判断
            startAt = new Date(date).getTime();
            if( endAt && startAt > endAt ){
                swal('时间格式不正确', '', 'error');
            }
        }
    });
//    ctrl + alt + l 快速的了格式化代码
//结束时间
    laydate({
        elem: "#date-end",
        format: "YYYY-MM-DD hh:mm:ss",
        istime: true,
        choose: function (date) {
//            判断一下起始时间是否存在,只有存在的情况下,才做判断
            endAt = new Date(date).getTime();
            if( startAt && startAt > endAt ){
                swal('时间格式不正确', '', 'error');
            }
        }
    });
})();

</script>
<script type="text/javascript">

    var dataTable = $("#data-table").DataTable({
        // 1. 设置中文语言
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Chinese.json",
        },
        columns: [
            {data: null, defaultContent: '' },
            {data: 'id'}, // 设置第一列
            {data: 'username'}, // 设置第二列
            {data: 'email'}, // 设置第三列
            {data: 'phoneNumber'},
            {data: 'updated_at'},
            {data: '', defaultContent: ''},  // 这一列不对应数据的任何的一个字段
        ], // 4. 定义数据的字段和表的列如何进行对应
        //5. 上面的这个数据是我们手工的写的，但是实际肯定是通过ajax技术去后台进行获取的，则我们现在需要使用DataTable插件发开启它的和后台进行交互的能力，然后使用ajax技术进行数据的获取（明白:前端和后端的通讯，不光有ajax技术 还有现在使用比较多的HTML5的新特性：web Socket：IM web的即时聊天工具 环信 融云..... 电商项目：在线的咨询 自己写websocket？ 完全是没必要，直接使用第三的环信 融云；或者是使用第三方的框架 workman swoole都可以）
        serverSide: true, // 开启服务器模式，现在datatable要使用Ajax和后台进行交互
        //6. 设置请求的地址，以及请求的类型 或者是携带参数 返回数据的类型
        ajax: {
            url: '{{ url('user/ajaxData') }}', // 后台请的地址
            type: 'post', // post提交
            // 传递给服务器的参数 是一个回调函数，这个回调函数的data参数，代表是datatable插件本身提供的数据
            data: function (data) {
//                console.log( data );
                // 7. 自定义的数据 ，只需要设置在data参数上面：每页显示数量
                data.pageSize = data.length;
                // 8.自定义的数据 页码计算 datatable分页公式
                data.page = data.start >= data.length ? Math.ceil(data.start / data.length
                ) + 1 : 1;
                data._token = "{{ csrf_token() }}";

//                获取用户搜索的条件
                data.startAt = $("#date-start").val();
                data.endAt = $("#date-end").val();
                data.keyWord = $("#keyword").val();


            }
        },
        createdRow: function (row, data) {
//            当datatable每渲染一行记录的时候，该回调函数就会执行一次，并且这个回调函数接收两个参数，
//            第一个参数代表是当前的这行DOM元素，
//           第二个参数代表是当前的这行数据 [{},{},{}]
//            console.log( data );
//            1. 先把row变成jquery对象
            $row = $(row);
            $row.find('td').eq(0).html('<input type="checkbox" name="delall" value="' + data.id + '">');
//            2.  处理对应的列
            $row.find('td').eq(6).html("<a href='{{ url('admin/user/edt') }}/" + data.id + "'>编辑</a> <a href='{{ url('admin/user/del') }}/" + data.id + "'>删除</a>");
        },
//        关闭datatable自带搜索
//        searching: false,
//        设置一下每页显示的数量
        lengthMenu: [[2, 5, 10, 20, 100], ['二', '五', '十', '二十', '一百']],
        columnDefs:[
//                第五列 操作列不需要排序 建议还是多看手册 手册那个地方可以操作
            {targets:0, bSortable:false}, // 代表是列的下标 从0开始，bSortable代表是否排序
            {targets:5, bSortable:false}, // 代表是列的下标 从0开始，bSortable代表是否排序
        ],
        order:[['1', 'asc']], // 设置默认的排序规则，但是第一个参数代表是使用那列（索引）

    });

//    点击页面的搜索的时候（携带对应的搜索条件），希望datatable的ajax请求进行执行
    $("#btn-search").click(function(){
        dataTable.ajax.reload(function (data) {
            // 当datatable使用ajax进行重新加载数据后该回调函数会自动的执行。data参数是服务器返回的信息
        });
    })

    $("#delAll").click(function () {
//        收集用户需要删除的行
        var oInput = $("input[name='delall']:checked");
        // 统计删除的行数 == 0. 同时还要获取删除的主键ID
        var ids = []; // 保存所有要删除的主键ID
        $.each(oInput, function(index, val){
            ids.push( $(val).val() );
        });
        if( ids.length == 0 ){
            swal('请先选择删除的记录', '', 'error');
            return false;
        }
        var _That = this;
//        发送ajax请求删除对应的记录信息
        $.ajax({
            'url': '{{ url("/admin/user/ajaxDel") }}',
            'type': 'post',
            dataType: 'json',
            data: {'ids': ids, '_token': '{{ csrf_token()  }}' },
            success: function(json){
                console.log( json );
                if(json.status == true && json.code == '1000'){
//                    使用datatable的ajax reload进行页面的重载
                    $(_That).attr('checked', false);
                    dataTable.ajax.reload(function (data) {
                        //.....
                    });

                }
            }
        })


    });

</script>
<script  type="text/javascript">
    $("#btn-add").click(function () {
        layer.open({
            type: 2, // 代表打开一个iframe层
            area: ['900px', '360px'],
            content: '{{ url("/admin/user/layeradd") }}',
            // 建议前端最后一般不写 有部分的前端的代码压缩工具 如果最后一个有逗号直接报错
//             uglify.js webpack grunt
        });
    })
</script>