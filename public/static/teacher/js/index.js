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
            url: '/teacher/Index/notice?notice_flag=' + 2,
            traditional: true,
            dataType: "json",
            success: function(data) {

                $(".grant").each(function(i){
                    var _this = $(this)
                    var class_name = $(this).parents("ul").prev().children('cite').html()

                    $.each(data, function(index, array) {
                        if (array['class_name'] == class_name) {
                            if (array['grant']) {
                                _this.append(' &nbsp;&nbsp;&nbsp;<span class="layui-badge">'+array['grant']+'</span>')
                            }
                        }
                    })
                });

                $(".leave").each(function(i){
                    var _this = $(this)
                    var class_name = $(this).parents("ul").prev().children('cite').html()

                    $.each(data, function(index, array) {
                        if (array['class_name'] == class_name) {
                            if (array['leave']) {
                                _this.append(' &nbsp;&nbsp;&nbsp;<span class="layui-badge">'+array['leave']+'</span>')
                            }
                        }
                    })
                });

                $(".reduction").each(function(i){
                    var _this = $(this)
                    var class_name = $(this).parents("ul").prev().children('cite').html()

                    $.each(data, function(index, array) {
                        if (array['class_name'] == class_name) {
                            if (array['reduction']) {
                                _this.append(' &nbsp;&nbsp;&nbsp;<span class="layui-badge">'+array['reduction']+'</span>')
                            }
                        }
                    })
                });
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

