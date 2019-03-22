<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $client=new GuzzleHttp\Client(['base_url'=>$url]);
        $r=$client->request('POST',$url,[
            'body'=>json_encode($data,JSON_UNESCAPED_UNICODE)
        ]);
        $arr=json_decode($r->getBody(),true);
        print_r($arr);


    }
}
