function excel(url){
     layui.use('upload', function() {
        var upload = layui.upload;
        var staffRoom = $('#staffRoom').val()
        var grade = $('#grade').val()
        var class_id = $('#class_id').val()

        //执行实例
        var uploadInst = upload.render({
            elem: '#excel',
            url: url + staffRoom+'&grade='+grade+'&class_id='+class_id,
            accept: 'file',
            field: 'excel',
            before: function() {
                load = layer.load()
            },
            done: function(data) {
                layer.close(load)
                if (data['valid']) {
                    layer.msg(data['msg'],{
                    icon: 1, //提示的样式
                    time: 800, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function() {
                        page(null);
                    }
                });
                } else {
                   layer.msg(data['msg'],{
                        icon: 2, //提示的样式
                        time: 1500, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    });
                }
            },
        });
    });
}

function checkbox() {
    $('.checkbox').click(function() {
        var checkbox = $('.checkbox')
        var flag = false;
        // checkbox.forEach(function(item, index){
        //     console.log(item)
        // })
        var arr = [];
        checkbox.each(function(item) {
            var c = $(this).attr('class')
            arr[item] = c
        })
        var flag = arr.every(function(item) {
            return item == "checkbox layui-unselect layui-form-checkbox layui-form-checked"
        })
        if (flag) {
            $('.header').addClass('layui-form-checked')
        } else {
            $('.header').removeClass('layui-form-checked')
        }

    })
}

function addAndEdit(url, hrefUrl) {
    layui.use(['form', 'layer', 'element'], function() {
        $ = layui.jquery;
        var form = layui.form,
            layer = layui.layer;
        var staffRoom = $('#staffRoom').val() || '';
        var id = $('#id').val() || '';
        var class_id = $('#class_id').val() || '';
        var stu_id = $('#stu_id').val() || '';
        var class_grade = $('#class_grade').val() || '';

        //监听提交
        form.on('submit(add)', function(data) {
            //发异步，把数据提交给php
            $.ajax({
                type: "post",
                url: url+class_id+'&stu_id=' + stu_id,
                traditional: true,
                dataType: "json",
                data: data.field,
                success: function(data) {
                    if (data['valid']) {
                        layer.alert(data['msg'], { icon: 6 }, function() {
                            location.href = hrefUrl+staffRoom+ '&class_id='+class_id+ '&grade='+class_grade;
                        });
                    } else {
                        layer.msg(data['msg']);
                    }
                }
            });
        });

    });
}

function del(url, id) {
    layer.confirm('确认要删除吗？', function(index) {
        ids = {};
        ids[0] = id;
        $.ajax({
            type: "post",
            url: url,
            traditional: true,
            dataType: "json",
            data: ids,
            success: function(data) {
                layer.msg('删除成功', {
                    icon: 1, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function() {
                        page(null);
                    }
                });
            }
        })
    });
}


function delAll(url) {
    var id = tableCheck.getData()
    if (!id.length) {
        layer.msg('请选择要删除的数据', {
            icon: 2, //提示的样式
            time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
            end: function() {
                layer.closeAll('dialog')
            }
        });
        return 0
    }
    layer.confirm('确认要删除吗？', function(index) {
        var id = tableCheck.getData()
        var ids = {};
        id.forEach(function(item, index) {
            ids[index] = item
        })
        $.ajax({
            type: "post",
            url: url,
            traditional: true,
            dataType: "json",
            data: ids,
            success: function(data) {
                layer.msg('删除成功', {
                    icon: 1, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function() {
                        $('.header').removeClass('layui-form-checked')
                        page(null)
                    }
                });
            }
        })
    });
}


function search(){
    $('#input').keypress(function(event) {
        var keynum = (event.keyCode ? event.keyCode : event.which);
        if (keynum == '13') {
            var val = $('#input').val();
            if (!val) {
                layer.msg('请填写您要查询的数据', {
                    icon: 2, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function() {
                        layer.closeAll('dialog')
                    }
                });
            } else {
                // var search = {}
                // search['sea'] = val
                // data = search
                page(val)
                $('#input').val('');
            }
        }
    });
    $('#search').click(function() {
        var val = $('#input').val();
        if (!val) {
                layer.msg('请填写您要查询的数据', {
                    icon: 2, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function() {
                        layer.closeAll('dialog')
                    }
                });
            } else {
                // var search = {}
                // search['sea'] = val
                // data = search
                page(val)
                $('#input').val('');
            }
    })
}

