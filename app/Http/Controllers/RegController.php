<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RegisterModel;
use App\Model\AppModel;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class RegController extends Controller
{
    //注册视图
    public function register(){
        return view('reg/create');
    }

    //注册的编辑
    public function regdo(Request $request){
        $post=request()->except('_token');

        $person=request()->input('person');

        //判断密码
         $pass=request()->input('pass');
         $pass1=request()->input('pass1');
         if($pass!=$pass1){
            echo "密码不正确 请重新输入";
            die;
         }

        // 文件上传
        if(request()->hasFile('scope')){
            $data['scope']=$this->upload('scope');
        }

        //密码加密
        $pass=password_hash($post['pass'],PASSWORD_BCRYPT);

        //入库
        $data=[
            'corp'      =>$post['corp'],
            'person'    =>$person,
            'scope'     => $post['scope']??'',
            'tel'       =>$post['tel'],
            'email'     =>$post['email'],
            'pass'      =>$pass,
            'address'   =>$post['address']
        ];
        $uid=RegisterModel::insertGetId($data);
        echo "<script>alert('注册成功');location.href='/login';</script>";

        //生成用户的appid 以及secret
        $appid=RegisterModel::gernerateAppid($person);
        $secret=RegisterModel::gernerateSecret();

        //将用户的appid 以及secret存入到app表中
        $userinfo=[
            'uid'     =>$uid,
            'appid'   =>$appid,
            'secret'  =>$secret
        ];
        $aid=AppModel::insertGetId($userinfo);
        if($aid>0){
            echo "ok";
        }else{
            echo "NO 请联系管理员";
        }

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

        //生成token标识 返给客户端（存入cookie）
        $token=str::random(16);
        Cookie::queue('token',$token,60);

        //将token保存到redis中
        $redis_token="token:".$token;
        $token_info=[
            'uid'            =>$username['id'],
            'person'         =>$username['person'],
            'login_time'    =>time()
        ];

        Redis::hMset($redis_token,$token_info);
        Redis::expire($redis_token,60*60);

        echo "<script>alert('登录成功 正在为你跳转到个人中心');location.href='/center';</script>";
    }


    //个人中心
    public function center(){
        //取出cookie中的token
        $token=cookie::get('token');
       // print_r($token);echo "<br>";

        //得到 token  拼接redis key
        $redis_token="token:".$token;
        //echo $key=$redis_token;echo "<br>";

        $token_info=Redis::hgetAll($redis_token);
        //print_r($token_info);echo "<br>";

        //获取用户信息
        $appinfo=AppModel::where(['uid'=>$token_info['uid']])->first()->toArray();
        //var_dump($appinfo);

        $appid=$appinfo['appid'];
        $secret=$appinfo['secret'];
        $person=$token_info['person'];

        return view('reg/center',['appid'=>$appid,'secret'=>$secret,'person'=>$person]);
    }

    //获取accesstoken接口
    public function getAccessToken(Request $request){
        $appid=$request->input('appid');
        $secret=$request->input('secret');

        //判断
        if(empty($appid)||empty($secret)){
            echo "缺少用户信息";die;
        }

        //为用户生成access_token 以便后续调用
        $appsecret=$appid.$secret.time().mt_rand().str::random(16);
        $access_token=sha1($appsecret).md5($appsecret);

        //将access_token存入到redis中  redis hash
        $redis_h_token="h_token:".$access_token;

        $info=[
            'appid'    =>$appid,
            'addtime' =>date('Y-m-d H:i:s')
        ];


        Redis::hMset($redis_h_token,$info);
        Redis::expire($redis_h_token,7200);

        $arr=[
            'error'           =>0,
            'access_token'   =>$access_token,
            'expire'         =>7200
        ];

        return $arr;
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

}
