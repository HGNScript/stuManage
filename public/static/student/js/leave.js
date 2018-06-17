$(function(){

    submit()
    $('.definite').blur(function(){
        var _this = $(this)
        showBorder(_this);
    })
    $('.layui-input').blur(function(){
        var _this = $(this)
        showBorder(_this);
    })


    layui.use('laydate', function(){
        var laydate = layui.laydate;
          //执行一个laydate实例
        laydate.render({
          elem: '#time'
          ,done: function(value, date, endDate){ //监听日期被切换
             if (!value) {
                $('#time').css({"border-color": "#FF0000"})
            } else {
                $('#time').css({"border-color": "#5FB878"})
            }
          }
        })
    })
    layui.use('laydate', function(){
        var laydate = layui.laydate;
          //执行一个laydate实例
        laydate.render({
          elem: '#time2',
          done: function(value, date, endDate){ //监听日期被切换
            if (!value) {
                $('#time2').css({"border-color": "#FF0000"})
            } else {
                $('#time2').css({"border-color": "#5FB878"})
            }
          }
        })
    })
 })


function submit(){
    $('#leavefoKeep').click(function(){
        var data = $("#leave").serialize();
        $.ajax({
            type: "post",
            url: '/student/Stuleave/submit',
            traditional: true,
            dataType: "json",
            data: data,
            success: function(data) {
                if (data['valid']) {
                    // location.href='/index';
                    layer.msg(data['msg'],{
                        icon: 1, //提示的样式
                        time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        end: function(){
                            location.reload();
                            // location.href="/stuIndex"
                        }
                    });
                } else{
                    layer.msg(data['msg'],{
                        icon: 2, //提示的样式
                        time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    });
                }
            }
        });
    })

    $('#leavefoSubmit').click(function(){
        var info = $("#leave").serialize();

        layer.confirm('确定要提交吗，提交后将不可更改', function(index) {
            $.ajax({
                type: "post",
                url: '/student/Stuleave/submit?leave_flag=1',
                traditional: true,
                dataType: "json",
                data: info,
                success: function(data) {
                    console.log(data)
                    if (data['valid']) {
                        // location.href='/index';
                        layer.msg(data['msg'],{
                            icon: 1, //提示的样式
                            time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                            end: function(){
                                location.reload();
                                location.href="/stuIndex"
                            }
                        });
                    } else{
                        layer.msg(data['msg'],{
                            icon: 2, //提示的样式
                            time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        });
                    }
                }
            });
        });

    })
}

function showBorder(_this) {
    var value = _this.val();
    if (!value) {
        _this.css({"border-color": "#FF0000"})
    } else {
        _this.css({"border-color": "#5FB878"})
    }
}