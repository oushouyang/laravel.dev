<?php 
// 1. 命名空间，和目录是严格的对应（类的自动载入）
namespace App\Http\Controllers\Admin;

// 2. 基类控制器，这个是laravel提供，里面存在很多有用的方法 OOP里面的继承
use App\Http\Controllers\Controller;

// 引入
use App\Http\Models\UserModel;

use Alert;

// 引入
use App\User;
use Illuminate\Http\Request;

// 使用自定义的验证类文件
use App\Http\Requests\UserAddRequest;

// 引入加密类
use Illuminate\Support\Facades\Crypt;


// 3. 类名必须和文件名一致
class UserController extends Controller
{
    public function add(Request $req)
    {
        if( request()->isMethod('post') ){
            // 在laravel里面如果验证不通过，会将错误的信息保存在一次性session里面，然后在返回上一个页面，我们在上一个页面则可以获取该一次性session里面的数据，然后在页面上显示（sweet alert）做一个弹出。注意：一次性session取了之后就没有。只能取一次
            $this->validate($req, [
                    'username' => 'required|min:2|max:10', // 不能为空 长度 2-10 多个规则是 | 
                    'password' => 'required|min:2|max:10', // 不能为空 长度 2-10 多个规则是 | 
                    'email' => 'required|min:5|max:30|email', // 不能为空 长度 5-30 多个规则是 |
                    'phoneNumber' => 'required|min:11|max:20', // 不能为空 长度 11-20 多个规则是 |
                ]);
            // 2. 准备入库 模型负责数据的处理 MVC
            $userModel = new UserModel();
            // 1. 图片上传
            if( $req->hasFile('pic') ){
                $file = $req->file('pic'); // 2. 图片对象
                // 3. 将上传的图片移动到磁盘上
                $fileName = uniqid() . '.'. $file->getClientOriginalExtension(); // 获取图片的后缀
                $target = "uploads/"; //相对于public里面的index.php入口文件
                $file->move($target, $fileName);
                // 4. 将上传的图片的路径保存在模型对象上面
                $userModel->pic = $fileName;
            }
            // 特点：如果验证通过，则下面的代码可以执行，如果不通过，则把错误保存一次性session中，然后调回上一个页面

            // 1. 接收数据 百度： laravel里面的 request()函数 总结
            $username = request()->input('username');
            $password = request()->input('password');
            $email = request()->input('email');
            $phoneNumber = request()->input('phoneNumber');


            // 3. ORM机制，建议把表中的字段和模型的属性形成对应的关系
            // $userModel->id = 101; 代表是更新
            $userModel->username = $username;
            // 注意： 在laravel里面不建议是 md5加密 容易被破解，内部存在专门的加密的类 方法

            // 长度 不是 32 一般来说 设置成 255即可 密文自动验证限制长度 不定长
            // 登录验证的需要额外的处理
            $userModel->password = Crypt::encrypt($password); 

                $userModel->email = $email;
            $userModel->phoneNumber = $phoneNumber;

            // 4. 入库
            $rs = $userModel->save(); // 1. 添加  2. 更新（主要是根据数据里面是否包含主键ID）
            if($rs){
//                并不想往列表页跳。关闭当前的模态框？
                $string = <<<HTML
                    <script type="text/javascript">
                        var index = parent.layer.getFrameIndex(window.name);
                        setTimeout(function(){
                            parent.layer.close(index);
                            parent.swal('添加成功', '', 'success');
                        }, 300);
                    </script>
HTML;
                echo $string;


//                return redirect('/admin/user/lst');
            }else{
                // 前提：1. use Alert 2. 静态页使用 sweet alert 插件的资源 
                Alert::message('添加失败', '提示信息'); // 把错误信息保存在session里面 真正要显示还是静态页 swal();
//                return back();
                $string = <<<HTML
                <script type="text/javascript">
                        parent.location.href="url('admin/user/add')";
                 </script>
HTML;
                echo $string;

            }
        }else{
            return view('user.add');
        }


        
    }
    public function lst()
    {
        // 获取数据库的数据
//        $userModel = new UserModel();
//        $userData = $userModel::all(); // 并不是自身，系统模型Model 集合 支持遍历 实现遍历的接口
        // 载入视图
        $size = 2;
        $userObj = UserModel::paginate($size);
//        $userObj = UserModel::simplePaginate($size); // 模型对象 = 数据->foreach + 分页->render();
        // 在其他的框架里面还需要使用分页类，但是laravel里面模型自带分页的功能

        return view('user.lst', ['userObj' => $userObj]);

    }

    public function edt($id = 0)
    {   
        if( request()->isMethod('post') ){
            $id = request()->input('id'); // 更新条件
            $userInfo = UserModel::find($id); // $userInfo 模型对象 当前的记录 ORM机制 

            $userInfo->username = request()->input('username');
            // 用户有可能没有填写，则代表不修改 不设置即可
            if( request()->input('password') ){
                $userInfo->password = Crypt::encrypt( request()->input('password') );;
            }
            $userInfo->email =  request()->input('email');
            $userInfo->phoneNumber =  request()->input('phoneNumber');

            $rs = $userInfo->save();
            if($rs){
                return redirect('/admin/user/lst');
            }else{
                return back();
            }
        }else{
            // 展示待更新的数据
            $userInfo = UserModel::find($id);
            return view('user.edt', ['userInfo' => $userInfo]);
        }
        
    }

    public function del($id = 0)
    {
        // 模型
        $userModel = new UserModel();
        // 1. laravel里面的先对应的记录查询出来，2. 在根据返回值删除
        $userObj = $userModel::find($id);
        $rs = $userObj->delete();
        if($rs){
            return redirect('/admin/user/lst');
        }else{
            return back();
        }
    }

    public function ajaxData(Request $request)
    {
        // 返回数据 在datatable插件里面的返回数据有严格的要求，需要满足四个条件
        // 1. 设置请求的次数，是datatable客户端提交的数据，原样返回即可draw
        // 2. 返回数据的总的记录（前台根据这个做分页）recordsTotal
        // 3. 还要返回查询后后的满足条件的总记录 recordsFiltered
        // 4. 返回对应的数据 data
        // 5. 分页显示数据
        $pageSize = $request->get('pageSize');
        $page = $request->get('page');
        $offset = ($page - 1) * $pageSize;

        // 6. 获取用户搜索的条件，用户有可能没有点击搜索 默认获取
        //  做查询的时候，我们可以使用一下laravel提高的一个查询构造器，该构造器可以拼接条件，然后在进行查询
        $query = UserModel::query();

        $startAt = $request->get('startAt');
        if($startAt){
            $query->where('updated_at', '>=', $startAt);
        }
        $endAt = $request->get('endAt');
        if($endAt){
            $query->where('updated_at', '<=', $endAt);
        }
        $keyWord = $request->get('keyWord');
        if($keyWord){
            $query->where('username', 'like', "%{$keyWord}%"); // 索引失效
        }
//        使用datatable自带的搜索功能，需要注意search单元是一个数组
        $searchWord = $request->get('search')['value'];
        if($searchWord){
            $query->where('username', 'like', "%{$searchWord}%"); // 索引失效
        }

//        7。 根据用户的选择的排序规则进行数据的处理
//        order[0][column]:2
//        order[0][dir]:asc

        $orderIndex = $request->get('order')[0]['column']; // 并不是排序的字段，只是排序的索引
        $orderby = ['id', 'id', 'username', 'email', 'phoneNumber']; // 排序字段
        $orderWay = $request->get('order')[0]['dir']; // asc desc


        // 8. 获取满足搜索条件的总记录和数据，并且做排序
        $count = $query->count();
        $userData = $query->offset($offset)->limit($pageSize)->orderBy( $orderby[ $orderIndex ], $orderWay)->get();

        $data = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $count,
            'recordsFiltered' => $count, // 注意：满足搜索条件的总计，现在还没有做搜索，暂时以总记录为准
            'data' => $userData,
        ];
        return $data; // 不用使用json_encode()处理，laravel框架自动的会处理以 []方式的数据
    }

    public function ajaxDel(Request $request)
    {
        $ids = $request->get('ids');
//        in (12, 2, 3) get()返回的是一个集合 存在一个each方法
//        UserModel::whereIn('id', $ids)->get() 获取所以的记录信息是一个集合
//        UserModel::whereIn('id', $ids)->get() 集合里面存在很多有用的方法， 是laravel本身提供的
        UserModel::whereIn('id', $ids)->get()->each(function($item){
            $item->delete();
        });

        return [
            'status' => true,
            'code' => '1000',
            'msg' => '删除成功！'
        ];

    }

    public function layeradd()
    {
        return view('user.layeradd');
    }

    public function test()
    {
        
        // $mingwen = 'admim8899999999999999999999999999'; // 5-8 大小写字母 数字 部分的特殊字符
        // 1 长度不定 2 每次加出的密文会变化
        // $miwen = Crypt::encrypt($mingwen);

        $miwen = 'eyJpdiI6InZxQTZsV2lJQmtvQWZkdEtSa01xQ3c9PSIsInZhbHVlIjoib3ZvcWVEV1ZESGhkNzlTRlU5bUV0UT09IiwibWFjIjoiNTJjM2NkNDQ2ZjUwOWYwOWVmZTYzYTQzZjZiMTAwODViMDAxNTc1MjBjMDk5NTJlZmE1MGY1NDAxZmJmMGUzMyJ9';
        $mingwen = Crypt::decrypt($miwen);

        // 验证： 不能验证密文 要验证明文

        var_dump($mingwen);

    }
}



 ?>