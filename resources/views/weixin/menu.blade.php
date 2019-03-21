<form action="/weixin/docreate" method="post">
    <div class="one_div">
        <h5>一级菜单</h5>
        类型：
        <select name="onetype" class="one_type"  style="width:100px; height:25px;">
            <option value="">请选择</option>
            <option>click</option>
            <option>view</option>
        </select>
        <b></b>
        {{--<button ><a href="#" class="one_clone">克隆</a></button>--}}
        <input type="button" class="one_clone" value="克隆">
        <div class="two_div">
            <h5>二级菜单</h5>
            二级菜单类型：
            <select name="twotype" class="type"  style="width:100px; height:25px;">
                <option value="">请选择</option>
                <option>click</option>
                <option>view</option>
            </select>
            <b></b>
            <input type="button" class="two_clone" value="克隆">
        </div>
    </div>
    <input type="submit" value="发布" id="btn">
</form>
<script src="{{URL::asset('/js/jquery-3.2.1.min.js')}}"></script>
<script>
    $(function () {
        //一级菜单克隆
        $(document).on('click','.one_clone',function () {
            var _this=$(this)
            var _num=$('.one_type').length
            if(_num>2){
                alert('一级菜单最多三个')
                return false
            }
            var _div=$('.one_div').parent().children().first().html();
            var _div="<div class='one_div'>"+_div+"</div>"
            _this.parent().last().after(_div)

        })
        //二级菜单克隆
        $(document).on('click','.two_clone',function () {
            var _this=$(this)
            var _num=_this.parent().siblings('div').length
            if(_num>=2){
                alert('二级菜单最多三个')
                return false
            }
            var two_div=_this.parent().html()
            var _div="<div class='two_div'>"+two_div+"</div>"
            _this.parent().after(_div)
        })
        //切换类型出不同效果
        //一级菜单类型
        $(document).on('change','.one_type',function () {
            var _this=$(this);
            var _val=_this.val();
            if(_val=='click'){
                var _input=" 一级菜单名称："+
                    "       <input type='text' name='onename[]'>" +
                    "       一级菜单键名 "+
                    "       <input type='text' name='onekey[]'>";
                _this.next().empty();
                _this.next().html(_input)
            }else if(_val=='view'){
                var _input="一级菜单名称："+
                    "       <input type='text' name='onename[]'>" +
                        "       一级菜单键名 "+
                    "       <input type='text' name='onekey[]'>"+
                    "       跳转地址："+
                    "       <input type='text' name='oneurl[]'>"
                _this.next().empty();
                _this.next().html(_input)
            }else if (_val==''){
                _this.next().empty();
            }
        })
        //二级菜单类型
        $(document).on('change','.type',function () {
            var _this=$(this);
            var _val=_this.val();
            if(_val=='click'){
                var _input=" 二级菜单名称："+
                    "       <input type='text' name='twoname[]'>" +
                    "       二级菜单键名 "+
                    "       <input type='text' name='key[]'>";
                _this.next().empty();
                _this.next().html(_input)
            }else if(_val=='view'){
                var _input="二级菜单名称："+
                    "       <input type='text' name='twoname[]'>" +
                    "       一级菜单键名 "+
                    "       <input type='text' name='onekey[]'>"+
                    "       跳转地址："+
                    "       <input type='text' name='twourl[]'>"
                _this.next().empty();
                _this.next().html(_input)
            }else if (_val==''){
                _this.next().empty();
            }
        })
    })
</script>
