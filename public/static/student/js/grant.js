$(function(){
    submit()

    var grant_flag = $('#grant_flag').val()

    if (grant_flag == 1 || grant_flag == 2) {
        $('input').attr('disabled','disabled')
        $('.submit').attr('disabled','disabled')
    } else {
        $(document).ready(function(){
            $(document).bind("contextmenu",function(e){
                return false;
            });
        })
    }

})

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
            url: '/student/Stugrant/grant',
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

        if( $("#pc").css("display")=='none') {
            data = $("#yidong").serialize()
        } else {
            data = $("#pc").serialize()
        }

        layer.confirm('确定要提交吗，提交后将不可更改', function(index) {
            $.ajax({
                type: "post",
                url: '/student/Stugrant/grant?grant_flag=1',
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

    })
}