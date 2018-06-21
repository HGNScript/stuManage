$(function(){
    de()

    var editPsd = function() {
        layui.use(['form', 'layer', 'element'], function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;
            //监听提交
            form.on('submit(add)', function(data) {
                $.ajax({
                    type: "post",
                    url: '/student/Index/editPsd',
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


    function de(){
        $('a.test').on('click', function(event) {  
        var info_falg = $('#stu_infoflag').val()
            if (info_falg == 0) {
                layer.alert('请先提交个人信息后才可进行下一步的操作', {icon: 2});  
                event.preventDefault();     
            }
        });    
    }


    var _main = function(){
        editPsd()
    }
    _main()
})

