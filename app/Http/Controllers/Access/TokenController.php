<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TokenController extends Controller
{
    public function test(Request $request){
       //验证token是否可用
        $token = $request->get('token');
        if (empty($token)) {
            echo "授权失败 缺少access_token";
            die;
        }

        $redis_h_token="h_token:".$token;
        $data = Redis::hGetAll($redis_h_token);

        if (empty($data)) {
            echo "授权失败，access_token无效";
            die;
        }

        $data=[
            'name'   =>'lisi',
            'time'   =>date('Y-m-d H:i:s')
        ];
        return $data;
    }

    public function test1(){
        $data=[
            'name'   =>'zhangsan',
            'time'   =>date('Y-m-d H:i:s')
        ];
        return $data;
    }

}
