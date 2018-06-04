$(function(){
    var editPsd = function() {
        layui.use(['form', 'layer', 'element'], function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;
            //监听提交
            form.on('submit(edit)', function(data) {
                $.ajax({
                    type: "post",
                    url: '/teacher/Index/editPsd',
                    traditional: true,
                    dataType: "json",
                    data: data.field,
                    success: function(data) {
                        if (!data['msg']) {
                            layer.msg('密码修改成功', {
                                icon: 1, //提示的样式
                                time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                                end: function() {
                                    parent.location.reload();
                                }
                            });
                        } else {
                            layer.msg(data['msg'], {
                                icon: 2, //提示的样式
                                time: 1000,
                            });
                        }
                    }
                });

                return false;
            });

        });
    }

    var editInfo = function () {
        layui.use(['form', 'layer', 'element'], function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;
            //监听提交
            form.on('submit(add)', function(data) {
                $.ajax({
                    type: "post",
                    url: '/teacher/Index/editInfo',
                    traditional: true,
                    dataType: "json",
                    data: data.field,
                    success: function(data) {
                        if (!data['msg']) {
                            layer.msg('信息修改成功', {
                                icon: 1, //提示的样式
                                time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                                end: function() {
                                    parent.location.reload();
                                }
                            });
                        } else {
                            layer.msg(data['msg'], {
                                icon: 2, //提示的样式
                                time: 1000,
                            });
                        }
                    }
                });

                return false;
            });

        });
    }

    var notice = function (){
        $.ajax({
            type: "get",
            url: '/teacher/Index/notice',
            traditional: true,
            dataType: "json",
            success: function(data) {
               if (data['leaveNotice']) {
                $("#leave").append(' &nbsp;&nbsp;&nbsp;<span class="layui-badge leave">'+data['leaveNotice']+'</span>')
               } else if (data['grantNotice']) {
                    $("#grant").append(' &nbsp;&nbsp;&nbsp;<span class="layui-badge grant">'+data['grantNotice']+'</span>')
               } else if (data['reductionNotice']) {
                   $("#reduction").append(' &nbsp;&nbsp;&nbsp;<span class="layui-badge reduction">'+data['reductionNotice']+'</span>')
               }
            }
        });
    }


    var _main = function(){
        editPsd()
        editInfo()
        notice()

    }
    _main()
})

