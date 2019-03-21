<form action="">
    <div class="onebox">
        <button>一级菜单</button>
        名字：<input type="text" name="one">
        <input type="button" class="clone" value="一级菜单克隆">
        <br>
        <div class="tobox">
            <button>二级菜单</button>
            按钮类型：
            <select name="" class="type"  style="width:100px; height:25px;">
                <option value="">请选择</option>
                <option>click</option>
                <option>view</option>
            </select>
            <b></b>
            <input type="button" class="toclone" value="二级菜单克隆"><br>
        </div>
    </div>
</form>
<script src="{{URL::asset('/js/jquery-3.2.1.min.js')}}"></script>
<script>


    $(function(){
        $(document).on('click','.clone',function () {
            var _this=$(this);
            var _div=$('.onebox').first().html();
            _this.parent().after(_div);
            var num=$('.onbox').length;
            console.log(num);

        });
        $(document).on('click','.toclone',function () {
            var _this=$(this);
            var _div=$('.tobox').first().html();
            _this.parent().after(_div);
        });
        $(document).on('change','.type',function () {
            var _this=$(this);
            var _val=_this.val();
            if(_val=='click'){
                var _input="&nbsp;&nbsp;&nbsp;&nbsp;菜单名称：<input type='text' name='towname'>";
                _this.next().empty();
                _this.next().html(_input)
            }else if(_val=='view'){
                var _input="&nbsp;&nbsp;&nbsp;&nbsp;菜单名称：<input type='text' name='towname'>" +
                    "&nbsp;&nbsp;&nbsp;&nbsp;跳转地址：<input type='text' name='url'>"
                _this.next().empty();
                _this.next().html(_input)
            }else if (_val=''){
                _this.next().empty();
            }
        })
    })
</script>
