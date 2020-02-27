<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\str;

class RegisterModel extends Model
{
    //指派表名
    protected $table="register";

    //生成appid(由用户名+随机数+时间戳)
    public static function gernerateAppid($person){
        return 'Op'.substr(md5($person.time().mt_rand(11111,99999)),3,14);
    }


    //生成secret(由用户名+随机数+时间戳)
    public static function gernerateSecret(){
        return str::random(32);
    }
}
