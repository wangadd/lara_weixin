<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        if($arr['code']==1){
            $token=$arr['token'];
            $info=[
                'msg'=>'登录成功',
                'token'=>$token
            ];
        }else{
            $info=[
                'msg'=>'登录失败',
            ];
        }
        return $info;



    }
}
