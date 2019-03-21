<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp;
class WxController extends Controller
{
    protected $redis_access_token='str:access_token';
    /**
     * 菜单视图页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createMenu(){
        return view('weixin.menu');
    }

    /**
     * 执行创建菜单
     */
    public function doCreate(Request $request){
        $data=$request->input();
        $access_token=$this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $client=new GuzzleHttp\Client(['base_url'=>$url]);
        $info=[
            "button"=>[
                [
                    "type"=>"click",
                    "name"=>"测试1",
                    "key"=>"V1001_TODAY_MUSIC"
                ],
                [
                    "name"=>"菜单",
                    "sub_button"=>[
                        [
                            "type"=>"view",
                            "name"=>"测试2",
                            "url"=>"http://www.soso.com/"
                        ],
                        [
                            "type"=>"view",
                            "name"=>"测试3",
                            "url"=>"http://www.baidu.com/"
                        ]
                    ]
                ],
            ]
        ];
        $r=$client->request('POST',$url,[
            'body'=>json_encode($info,JSON_UNESCAPED_UNICODE)
        ]);
        $arr=json_decode($r->getBody(),true);
        if($arr['errcode']==0){
            echo "菜单创建成功";
        }else{
            echo "菜单创建失败，错误码是".$arr['errcode'];
        }

    }

    /**
     * 获取微信access_token
     * @return mixed
     */
    public function getAccessToken(){
        $token=Redis::get($this->redis_access_token);
        if(!$token){
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WEIXIN_APPID')."&secret=".env('WEIXIN_APPSECRET');
            $data=json_decode(file_get_contents($url),true);

            $token=$data['access_token'];
            Redis::set($this->redis_access_token,$token);
            Redis::setTimeout($this->redis_access_token,3600);
        }
        return $token;
    }



    public function test(){
        $url="http://www.api.com/index.html";
        $client=new GuzzleHttp\Client();
        $result=$client->request('GET',$url);
        $info=$result->getBody();
        echo $info;
    }



    public function login(){
        return view('login.login');
    }
    public function menu(Request $request){

        $data=[
            'login'=>$request->get('is_login')
        ];
        return view('login.menu',$data);
    }

}
