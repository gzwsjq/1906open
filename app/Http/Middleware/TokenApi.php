<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class TokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
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

        var_dump($data);

        return $next($request);
    }
}
