<?php

namespace App\Http\Controllers\admin;

use App\Http\Models\DeptModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DeptController extends Controller
{
    public function add(Request $request)
    {
        // 接收数据
        if( $request->isMethod('post') ){

            //  $data = $request->only(['dept_name', 'mark_up', 'pid']); only方法代表只接收规则的字段信息

            $obj =  DeptModel::create( $request->all() ); // 1. 接收数据 2. 直接入库 3. 排除_token字段
            if($obj){
                return redirect('/admin/dept/lst');
            }else{
                return back();
            }

        }else{
            // 展示
            // 获取所有的部门信息
            $deptModel = new DeptModel();
            $deptData = $deptModel->getTree(); // 使用递归获取部门的信息

            return view('dept.add', ['deptData' => $deptData]);
        }

    }

    public function lst()
    {
        $deptModel = new DeptModel();
        $deptData = $deptModel->getTree();

        return view('dept.lst', ['deptData' => $deptData]);
    }
}
