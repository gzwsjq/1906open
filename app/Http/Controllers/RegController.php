<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegisterModel;
use Validator;
use Illuminate\Validation\Rule;

class RegController extends Controller
{
    //注册视图
    public function register(){
        return view('reg/create');
    }

    //注册的编辑
    public function regdo(Request $request){
        $post=request()->except('_token');

        // 文件上传
        if(request()->hasFile('scope')){
            $data['scope']=$this->upload('scope');
        }

        //密码加密
        $pass=password_hash($post['pass'],PASSWORD_BCRYPT);

        //生成用户的appid 以及secret
        $post['appid']=mt_rand(11111,99999).time();
        $post['secret']=base64_encode(mt_rand(11111,99999).time());


        //入库
        $data=[
            'corp'      =>$post['corp'],
            'person'    =>$post['person'],
            'scope'     => $post['scope']??'',
            'tel'       =>$post['tel'],
            'email'     =>$post['email'],
            'pass'      =>$pass,
            'address'   =>$post['address'],
            'appid'     =>$post['appid'],
            'secret'    =>$post['secret']
        ];

        $res=RegisterModel::insertGetId($data);
        echo "<script>alert('注册成功');location.href='/login';</script>";
    }


    //上传文件
    function upload($file){
        if(request()->file($file)->isValid()) {
            $photo =request()->file($file);
            $store_result = $photo->store('uploads');

            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }


    //登录视图
    public function login(){
        return view('reg/login');
    }

    //登录的编辑
    public function logindo(){
        $post=request()->except('_token');
        $name=request()->input('name');  //用户登录的方式有 邮箱，手机号

        //用户
        $username=RegisterModel::where(['email'=>$name])->orwhere(['tel'=>$name])->first();
        if($username==null){
            echo "此用户不存在 请先注册";die;
        }

        //密码
        $pass=request()->input('pass');  //密码
        if(!password_verify($pass,$username->pass)){
            echo "密码不正确";die;
        }
        
        echo "<script>alert('登录成功 正在为你跳转到个人中心');location.href='/center';</script>";
    }
}
