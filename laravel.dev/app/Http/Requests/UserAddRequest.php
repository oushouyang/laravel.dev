<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserAddRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // get 直接放行
        if( request()->isMethod('get') ){
            return []; // 规则为空
        }

        // 只在post的时候做验证
        return [
            'username' => 'required|min:2|max:10',  
            'password' => 'required|min:2|max:10',  
            'email' => 'required|min:2|max:10|email',  
            'phoneNumber' => 'required|min:2|max:10', 

        ];
    }

    /**
     * 验证不通过的提示信息
     * @return array 
     */
    public function messages()
    {
        
        return [
            'username.required' => '用户名不能为空',
            'username.min' => '用户名最小长度必须2个字符',
            'password.required' => '密码不能为空',
            // ......
        ];  

    }
}
