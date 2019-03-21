<?php

namespace App\Admin\Controllers;

use App\Model\WxUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp;


class WxuserController extends Controller
{
    use HasResourceActions;
    public $redis_access_token_key="Wx_access_token";
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxUser);

        $grid->id('Id');
        $grid->uid('Uid');
        $grid->openid('Openid');
        $grid->add_time('Add time')->display(function ($add_time){
                return date("Y-m-d H:i:s",$add_time);
        });
        $grid->nickname('Nickname');
        $grid->sex('Sex')->display(function ($sex){
            if($sex==1){
                return "男";
            }elseif ($sex==2){
                return "女";
            }else{
                return "未知";
            }
        });
        $grid->headimgurl('Headimgurl')->display(function ($img){
            return "<img src='".$img."' width='50px' height='50px'>";
        });
        $grid->subscribe_time('Subscribe time')->display(function ($tme){
            return date("Y-m-d H:i:s",$tme);
        });
        $grid->unionid('Unionid');
        $grid->actions(function ($actions) {

            // append一个操作
            $actions->append('<a href="/admin/send"><i class="fa fa-eye">群发</i></a>');

        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WxUser::findOrFail($id));

        $show->id('Id');
        $show->uid('Uid');
        $show->openid('Openid');
        $show->add_time('Add time');
        $show->nickname('Nickname');
        $show->sex('Sex');
        $show->headimgurl('Headimgurl');
        $show->subscribe_time('Subscribe time');
        $show->unionid('Unionid');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxUser);

        $form->number('uid', 'Uid');
        $form->text('openid', 'Openid');
        $form->number('add_time', 'Add time');
        $form->text('nickname', 'Nickname');
        $form->switch('sex', 'Sex');
        $form->text('headimgurl', 'Headimgurl');
        $form->number('subscribe_time', 'Subscribe time');
        $form->text('unionid', 'Unionid');

        return $form;
    }

    /**
     * 群发试图
     * @param Content $content
     * @return Content
     */
    public function send(Content $content){
        return $content
            ->header('群发')
            ->description('description')
            ->body($this->form1());
    }
    protected function form1()
    {
        $form = new Form(new WxUser);

        $form->textarea('send')->rows(10);

        return $form;
    }

    /**
     * 执行群发
     * @param Request $request
     */
    public function doSend(Request $request)
    {
        $text = $request->input('send');
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=" . $access_token;

        $client = new GuzzleHttp\Client(['base_url' => $url]);
        $userInfo = WxUser::all();
        foreach ($userInfo as $v) {
            $openid[] = $v->openid;
        }
        $data = [
            "touser" => $openid,
            "msgtype" => "text",
            "text" => ["content" =>$text]
        ];
        $r=$client->request('POST',$url,[
            'body'=>json_encode($data,JSON_UNESCAPED_UNICODE)
        ]);
        $request_arr=json_decode($r->getBody(),true);
        if($request_arr['errcode']==0){
            echo "群发成功";
        }else{
            echo "请重新发送,errcode=".$request_arr['errcode']."errmsg".$request_arr['errmsg'];
        }


    }

    /**
     * 获取微信access_token
     * @return mixed
     */
    public function getAccessToken(){
        $access_token=Redis::get($this->redis_access_token_key);
        if(!$access_token){
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WEIXIN_APPID')."&secret=".env('WEIXIN_APPSECRET');
            $data=json_decode(file_get_contents($url),true);

            $access_token=$data['access_token'];
            Redis::set($this->redis_access_token_key,$access_token);
            Redis::setTimeout($this->redis_access_token_key,3600);
        }
        return $access_token;
    }
    /**
     * 创建菜单试图
     */
    public function menuview(Content $content){
        return $content
            ->header('创建自定义菜单')
            ->description('')
            ->body(view('wx_admin.menu'));
    }

    /**
     * 创建自定义菜单
     */
    public function createMenu(){
        $access_token=$this->getAccessToken();
        $url=" https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $client=new GuzzleHttp\Client(['base_url'=>$url]);

        $data=[
            "button"=>[
                [
                    "type"=>"click",
                    "name"=>"今日歌曲",
                    "key"=>"V1001_TODAY_MUSIC"
                ],
                [
                    "name"=>"菜单",
                    "sub_button"=>[
                        [
                        "type"=>"view",
                        "name"=>"搜索",
                        "url"=>"http://www.soso.com/"
                        ],
                    ]
                ],
            ]
        ];
        $r=$client->request('POST',$url,[
           'body'=>json_encode($data,JSON_UNESCAPED_UNICODE)
        ]);
        $info=json_decode($r->getBody(),true);
        if($info['errcode']==0){
            echo "菜单创建成功";
        }else{
            echo "菜单创建失败，错误码是".$info['errcode'];
        }
        
    }

}
