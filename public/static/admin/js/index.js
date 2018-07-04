$(function(){
    var delGrade = function() {
        $('.delGrade').click(function(){
            var grade = $(this).attr('data-grade');
            layer.confirm('确定要删除本年级吗', {icon: 3, title:'提示'}, function(index){
                layer.open({
                    type: 1,
                    content: $('#delgrade'), //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    btn: ['确定', '取消'],
                    yes: function(index, layero){
                        var password= $('#password').val()
                        console.log(password)
                        $.ajax({
                            type: "post",
                            url: '/admin/Index/delGrade?grade='+grade,
                            traditional: true,
                            dataType: "json",
                            data:{'password' : password},
                            success: function (data) {
                                if (!data['msg']) {
                                    layer.msg('删除成功', {
                                        icon: 1, //提示的样式
                                        time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                                        end: function () {
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
                    },
                });



                layer.close(index);
            });
        })
    }

    var editPsd = function() {
        layui.use(['form', 'layer', 'element'], function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;
            //监听提交
            form.on('submit(editPsd)', function(data) {
                $.ajax({
                    type: "post",
                    url: '/admin/Index/editPsd',
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
                    url: '/admin/Index/editInfo',
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

    var addGrade = function () {
        layui.use(['form', 'layer', 'element'], function () {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;
            //监听提交
            form.on('submit(addGrade)', function (data) {
                $.ajax({
                    type: "post",
                    url: '/admin/Index/addGrade',
                    traditional: true,
                    dataType: "json",
                    data: data.field,
                    success: function (data) {
                        if (!data['msg']) {
                            layer.msg('添加成功', {
                                icon: 1, //提示的样式
                                time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                                end: function () {
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
            });

        });
    }

    var gradeExpot = function () {
                
        $('.gradeExpot').click(function(){
            var stu_grade = $(this).attr('data-grade')

            $.ajax({
                type: "GET",
                url: '/admin/Classlist/gradeExpot?stu_grade=' + stu_grade ,
                traditional: true,
                dataType: "json",
                success: function (data) {
                    // if (!data['msg']) {
                    //     layer.msg('添加成功', {
                    //         icon: 1, //提示的样式
                    //         time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    //         end: function () {
                    //             parent.location.reload();
                    //         }
                    //     });
                    // } else {
                    //     layer.msg(data['msg'], {
                    //         icon: 2, //提示的样式
                    //         time: 1000,
                    //     });
                    // }
                }
            });
        })

                

    }

    var _main = function(){
        delGrade()
        editPsd()
        editInfo()
        addGrade()
        // gradeExpot()

    }
    _main()
})

