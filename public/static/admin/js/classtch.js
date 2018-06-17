var pageData = null;
$(function () {
    page(null)
    excel()
    addAndEditClasstch()
    search()

    $('body').keypress(function (event) {
        var keynum = (event.keyCode ? event.keyCode : event.which);
        if (keynum == '13') {
            if ($('#loginForm').length > 0) {
                addAndEditClasstch()
            }
        }
    });
})

function page(search) {
    var staffRoom = $('#staffRoom').val()
    layui.use('laypage', function () {
        var laypage = layui.laypage;
        var data = {'curr': null, 'limit': null, 'staffRoom': staffRoom, 'search': search};
        $.ajax({
            type: "post",
            url: '/admin/Classtch/index',
            traditional: true,
            dataType: "json",
            data: data,
            success: function (data) {
                var len = data.length
                pageData = data

                laypage.render({
                    elem: 'test1' //注意，这里的 test1 是 ID，不用加 # 号
                    ,
                    count: len, //数据总数，从服务端得到
                    limit: 5,
                    jump: function (obj, first) {
                        if (obj.curr > 1) {

                            var start = obj.curr * obj.limit-obj.limit

                            var data = pageData.slice(start, obj.curr * obj.limit)
                            console.log(data)
                        }

                        if (obj.curr == 1) {
                            var start = 0

                            var data = pageData.slice(start, start+obj.limit)
                        }


                        $("#tbody").empty();

                        var data_html = showData(data)

                        $("#tbody").append(data_html);
                        $('.layui-unselect').not('.header').click(function () {
                            $(this).toggleClass('layui-form-checked')
                        })

                        checkbox();
                    }
                });
            }
        })
    });
}

function excel() {
    layui.use('upload', function () {
        var upload = layui.upload;
        var staffRoom = $('#staffRoom').val()

        //执行实例
        var uploadInst = upload.render({
            elem: '#excel' //绑定元素
            ,
            url: '/admin/Classtch/excelAddClasstch?staffRoom=' + staffRoom //上传接口
            ,
            accept: 'file',
            field: 'excel',
            before: function () {
                load = layer.load()
            },
            done: function (data) {
                layer.close(load)
                if (data['valid']) {
                    layer.msg(data['msg'], {
                        icon: 1, //提示的样式
                        time: 800, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        end: function () {
                            page(null);
                        }
                    });
                } else {
                    layer.msg(data['msg'], {
                        icon: 2, //提示的样式
                        time: 1500, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    });
                }
            },
        });
    });
}

function checkbox() {
    $('.checkbox').click(function () {
        var checkbox = $('.checkbox')
        var flag = false;
        // checkbox.forEach(function(item, index){
        //     console.log(item)
        // })
        var arr = [];
        checkbox.each(function (item) {
            var c = $(this).attr('class')
            arr[item] = c
        })
        var flag = arr.every(function (item) {
            return item == "checkbox layui-unselect layui-form-checkbox layui-form-checked"
        })
        if (flag) {
            $('.header').addClass('layui-form-checked')
        } else {
            $('.header').removeClass('layui-form-checked')
        }

    })
}

function addAndEditClasstch() {
    layui.use(['form', 'layer', 'element'], function () {
        $ = layui.jquery;
        var form = layui.form,
            layer = layui.layer;
        var staffRoom = $('#staffRoom').val();
        var classtch_id = $('#id').val();
        if (!classtch_id) {
            classtch_id = ''
        }
        //监听提交
        form.on('submit(add)', function (data) {
            //发异步，把数据提交给php
            $.ajax({
                type: "post",
                url: '/admin/Classtch/addAndEditClasstch?classtch_id=' + classtch_id,
                traditional: true,
                dataType: "json",
                data: data.field,
                success: function (data) {
                    if (data['valid']) {
                        layer.alert(data['msg'], {icon: 6}, function () {
                            location.href = '/admin/Classtch/index?staffRoom=' + staffRoom;
                        });
                    } else {
                        layer.msg(data['msg']);
                    }
                }
            });
        });

    });
}

function del(obj, id) {
    layer.confirm('确认要删除吗？', function (index) {
        ids = {};
        ids[0] = id;
        $.ajax({
            type: "post",
            url: '/admin/Classtch/delClasstch',
            traditional: true,
            dataType: "json",
            data: ids,
            success: function (data) {
                layer.msg('删除成功', {
                    icon: 1, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function () {
                        page(null);
                    }
                });
            }
        })
    });
}


function delAll(argument) {
    var id = tableCheck.getData()
    if (!id.length) {
        layer.msg('请选择要删除的数据', {
            icon: 2, //提示的样式
            time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
            end: function () {
                layer.closeAll('dialog')
            }
        });
        return 0
    }
    layer.confirm('确认要删除吗？', function (index) {
        var id = tableCheck.getData()
        var ids = {};
        id.forEach(function (item, index) {
            ids[index] = item
        })
        $.ajax({
            type: "post",
            url: '/admin/Classtch/delClasstch',
            traditional: true,
            dataType: "json",
            data: ids,
            success: function (data) {
                layer.msg('删除成功', {
                    icon: 1, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function () {
                        $('.header').removeClass('layui-form-checked')
                        page(null)
                    }
                });
            }
        })
    });
}


function search() {
    $('#input').keypress(function (event) {
        var keynum = (event.keyCode ? event.keyCode : event.which);
        if (keynum == '13') {
            var val = $('#input').val();
            if (!val) {
                layer.msg('请填写您要查询的数据', {
                    icon: 2, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function () {
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
    $('#search').click(function () {
        var val = $('#input').val();
        if (!val) {
            layer.msg('请填写您要查询的数据', {
                icon: 2, //提示的样式
                time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                end: function () {
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

function showData(data) {
    var data_html = "";
    var authority = $('#authority').val()
    if (!data.length > 0) {
        $("#tbody").append('<td colspan="7" style="text-align: center;"> 暂时没有数据 </td>');
    } else {
        if (authority != 3) {
            $.each(data, function (index, array) {
                data_html += `<tr>
                                            <td>
                                        <div class="checkbox layui-unselect layui-form-checkbox" lay-skin="primary" data-id="` + array['classtch_id'] + `"><i class="layui-icon">&#xe605;</i></div>
                                        </td>
                                        <td>` + array['classtch_number'] + `</td>
                                        <td>` + array['classtch_name'] + `</td>
                                        <td>` + array['classtch_phone'] + `</td>
                                        <td>` + array['classtch_email'] + `</td>
                                        <td class="td-manage">
                                            <a title="编辑教师信息" href="/admin/Classtch/editClasstch?classtch_id=` + array['classtch_id'] + `&staffRoom=` + array['classtch_staffRoom'] + `">
                                            <span class="layui-badge-rim layui-bg-orange">编辑教师信息</span>
                                          </a>
                                                  <a title="删除" onclick="del(this,'` + array['classtch_id'] + `')" href="javascript:;">
                                                <span class="layui-badge">删除</span>
                                              </a>
                                                </td>
                                            </tr>`;
            });
        } else {
            $.each(data, function (index, array) {
                data_html += `<tr>
                                            <td>
                                        <div class="checkbox layui-unselect layui-form-checkbox" lay-skin="primary" data-id="` + array['classtch_id'] + `"><i class="layui-icon">&#xe605;</i></div>
                                        </td>
                                        <td>` + array['classtch_number'] + `</td>
                                        <td>` + array['classtch_name'] + `</td>
                                        <td>` + array['classtch_phone'] + `</td>
                                        <td>` + array['classtch_email'] + `</td>
                                            </tr>`;
            });

        }

    }
    return data_html
}

