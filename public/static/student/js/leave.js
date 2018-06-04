$(function(){

    submit()
    var leave_flag  = $('#leave_flag').val()
    if (leave_flag != 0) {
        $('input').attr('disabled','disabled')
        $('.submit').attr('disabled','disabled')
    }
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