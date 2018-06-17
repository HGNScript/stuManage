$(function(){
    submit()

    $('.print').click(function(){

        if ($('#reduction_flag').val() == 2) {
            doPrint()
        }
    })

    disabled();
})

function doPrint(){
    var head_str = "<html><head><title></title></head><body>"; //先生成头部
    var foot_str = "</body></html>"; //生成尾部
    var older = document.body.innerHTML;
    var new_str = document.getElementById('pc').innerHTML; //获取指定打印区域
    var old_str = document.body.innerHTML; //获得原本页面的代码
    document.body.innerHTML = head_str + new_str + foot_str; //构建新网页
    window.print(); //打印刚才新建的网页
    document.body.innerHTML = old_str; //将网页还原
    $('.print').click(function(){
        doPrint()
    })
    return false;
}

function disabled() {
    $(document).ready(function(){
        $(document).bind("contextmenu",function(e){
            return false;
        });
    })

    window.addEventListener('keydown', function (evt) {
        if (!evt.ctrlKey || (evt.key !== 'p' && evt.keyCode !== 80)) {
        } else {
            event.returnValue=false;
        }

    })

}

function submit(){
    $('#leavefoKeep').click(function(){
        var data= null

        if( $("#pc").css("display")=='none') {
            data = $("#yidong").serialize()
        } else {
            data = $("#pc").serialize()
        }

        $.ajax({
            type: "post",
            url: '/student/Stureduction/reduction',
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
        var data= null

        if ($('#grant_flag').val() == 0 || $('#grant_flag').val() == 3) {
            if( $("#pc").css("display")=='none') {
                data = $("#yidong").serialize()
            } else {
                data = $("#pc").serialize()
            }

            layer.confirm('确定要提交吗，提交后将不可更改', function(index) {
                $.ajax({
                    type: "post",
                    url: '/student/Stureduction/reduction?reduction_flag=1',
                    traditional: true,
                    dataType: "json",
                    data: data,
                    success: function(data) {
                        if (data['valid']) {
                            layer.msg(data['msg'],{
                                icon: 1, //提示的样式
                                time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                                end: function(){
                                    location.reload();
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

        }


    })
}