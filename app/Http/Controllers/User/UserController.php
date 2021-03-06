<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp;

class UserController extends Controller
{
    public function login(Request $request){
        $email=$request->input('email');
        $pwd=$request->input('pwd');
        $data=[
            'email'=>$email,
            'pwd'=>$pwd
        ];
        $url="http://hao.tactshan.com/login";
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        $rs = curl_exec($ch);
        $arr=json_decode($rs);
        if($arr->code==1){
            $token=$arr->token;
            $info=[
                'msg'=>'登录成功',
                'token'=>$token,
                'uid'=>$arr->uid
            ];
        }else{
            $info=[
                'msg'=>'登录失败',
            ];
        }
        return $info;



    }
    public function quit(Request $request){
        $token=$request->input('token');
        $uid=$request->input('uid');
        $key="token:app:".$uid;
        Redis::hdel('token',$key);
        $info=[
            'msg'=>'退出成功',
        ];
        echo json_encode($info);
    }
}
