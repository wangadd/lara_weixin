<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>许愿墙</title>
    <link rel="stylesheet" href="{{URL::asset('/wish/Css/index.css')}}" />
    <script type="text/javascript" src="{{URL::asset('/wish/Js/jquery-1.7.2.min.js}}"></script>
    <script type="text/javascript" src="{{URL::asset('/wish/Js/index.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('wish/Js/iepng.js')}}"></script>
</head>
<body>
<div id='top'>
    <span id='send'></span>
</div>
<div id='main'>
    <dl class='paper a1'>
        <dt>
            <span class='username'></span>
            <span class='num'>许愿ID</span>
        </dt>
        <dd class='content'></dd>
        <dd class='bottom'>
            <span class='time'></span>
            <a href="" class='close'></a>
        </dd>
    </dl>

</div>

<div id='send-form'>
    <p class='title'><span>许下你的愿望</span><a href="" id='close'></a></p>
    <form action="wish_add.php" method="post" name='wish'>
        <p>
            <label for="username">昵称：</label>
            <input type="text" name='username' id='username'/>
        </p>
        <p>
            <label for="content">愿望：(您还可以输入&nbsp;<span id='font-num'>50</span>&nbsp;个字)</label>
            <textarea name="content" id='content'></textarea>
            <!--<div id='phiz'>-->
            <!--<img src="./Images/phiz/zhuakuang.gif" alt="抓狂" />-->
            <!--<img src="./Images/phiz/baobao.gif" alt="抱抱" />-->
            <!--<img src="./Images/phiz/haixiu.gif" alt="害羞" />-->
            <!--<img src="./Images/phiz/ku.gif" alt="酷" />-->
            <!--<img src="./Images/phiz/xixi.gif" alt="嘻嘻" />-->
            <!--<img src="./Images/phiz/taikaixin.gif" alt="太开心" />-->
            <!--<img src="./Images/phiz/touxiao.gif" alt="偷笑" />-->
            <!--<img src="./Images/phiz/qian.gif" alt="钱" />-->
            <!--<img src="./Images/phiz/huaxin.gif" alt="花心" />-->
            <!--<img src="./Images/phiz/jiyan.gif" alt="挤眼" />-->
            <!--</div>-->
        </p>
        <!--图像域也有提交的功能  type="image"-->
        <input type="image" src="Images/send-btn.png" style="width:120px;height:50px;float:right;margin:10px;border:0;">
    </form>
</div>
<!--[if IE 6]>

<script type="text/javascript">
    DD_belatedPNG.fix('#send,#close,.close','background');
</script>
<![endif]-->
</body>
</html>