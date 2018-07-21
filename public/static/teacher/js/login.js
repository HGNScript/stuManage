$(function() {

    var login = function() {
        var info = $("#loginForm").serialize();
        $.ajax({
            type: "post",
            url: '/tchLogin',
            traditional: true,
            dataType: "json",
            data: info,
            beforeSend: function (XMLHttpRequest) {
                index = layer.load()
            },
            success: function(data) {
                layer.close(index)
                
                if (!data['msg']) {
                    location.href='/tchIndex';
                } else{
                    layer.msg(data['msg'],{
                        icon: 2, //提示的样式
                        time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    });
                }
            }
        });
    }

    var getValidate = function () {
        var flag = true
        $('#getValidate').click(function () {
            if (flag) {
                var info = $("#editPsd").serialize();
                $.ajax({
                    type: "post",
                    url: '/teacher/Login/getValidate',
                    traditional: true,
                    dataType: "json",
                    data: info,
                    success: function (res) {
                        if (res['res']['valid'] == 1) {
                            if (res['res']['msg'].detail[0]['result'] == 0) {
                                layer.msg("验证码发送成功", {
                                    icon: 1, //提示的样式
                                    time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                                    end: function () {
                                        flag = false
                                        $('#validateVal').val(res['validate'])

                                        $('#getValidate').removeClass('layui-btn-primary')
                                        $('#getValidate').addClass('layui-btn-disabled')

                                        $('#getValidate').html()
                                        var time = 30;
                                        $('#getValidate').html(time + 's后再次发送信息')

                                        var settime = setInterval(function () {
                                            time--
                                            $('#getValidate').html(time + 's后再次发送信息')
                                            if (time == 0) {
                                                flag = true
                                                clearInterval(settime)
                                                $('#getValidate').removeClass('layui-btn-disabled')
                                                $('#getValidate').addClass('layui-btn-primary')
                                                $('#getValidate').html('获取验证码')
                                            }
                                        }, 1000)
                                    }
                                });
                            } else {
                                layer.msg(res['res']['msg'].detail[0]['errmsg'] + ",验证码发送不成功")
                            }
                        } else {
                            layer.msg(res['res']['msg'], {
                                icon: 2, //提示的样式
                                time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                            });
                        }
                    }
                });
            } else {
                return 0
            }
        })


    }

    var editPsd = function(){
        $('#submit').click(function () {
            var info = $("#editPsd").serialize();
            $.ajax({
                type: "post",
                url: '/teacher/Login/editPsd',
                traditional: true,
                dataType: "json",
                data: info,
                success: function (data) {
                    console.log(data)
                    if (data['code'] == 0) {
                        layer.msg(data['msg'], {
                            icon: 1, //提示的样式
                            time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                            end: function(){
                                parent.location.reload();
                            }
                        });
                    } else {
                        layer.msg(data['msg'], {
                            icon: 2, //提示的样式
                            time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        });
                    }
                }
            });
        })
    }


    var _main = function() {
        $('#login').click(function() {
            login()
        })
        $('input').keypress(function(event) {
            var keynum = (event.keyCode ? event.keyCode : event.which);
            if (keynum == '13') {
                login()
            }
        });

        getValidate()
        editPsd()
    }
    _main()
})