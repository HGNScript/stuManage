var pageData = null;
$(function () {
    page(null);

    var excelurl = '/admin/Classinfo/excelAddStu?staffRoom=';
    excel(excelurl);

    var addAndEditurl = '/admin/Classinfo/addAndEditStu?class_id=';
    var hrefUrl = '/admin/Classinfo/index?staffRoom='
    addAndEdit(addAndEditurl, hrefUrl)

    delAllClick()
    search()

})

function page(search) {
    var staffRoom = $('#staffRoom').val()
    var class_id = $('#class_id').val()
    layui.use(['laypage','layer'], function () {
        var laypage = layui.laypage;
        var data = {'curr': null, 'limit': null, 'staffRoom': staffRoom, 'search': search};
        $.ajax({
            type: "post",
            url: '/admin/Classinfo/index?class_id=' + class_id,
            traditional: true,
            dataType: "json",
            data: data,
            beforeSend: function (){
                parent.layer.load()
            },
            success: function (data) {
                parent.layer.closeAll();

                var len = data.length
                $('#count').html(len)

                pageData = data

                laypage.render({
                    elem: 'test1' //注意，这里的 test1 是 ID，不用加 # 号
                    ,
                    count: len, //数据总数，从服务端得到
                    limit: 10,
                    jump: function (obj, first) {

                        if (obj.curr > 1) {

                            var start = obj.curr * obj.limit-obj.limit

                            var data = pageData.slice(start, obj.curr * obj.limit)
                        }

                        if (obj.curr == 1) {
                            var start = 0

                            var data = pageData.slice(start, start+obj.limit)
                        }

                        $("#tbody").empty()

                        var data_html = showData(data)

                        $("#tbody").append(data_html);
                        $('.layui-unselect').not('.header').click(function () {
                            $(this).toggleClass('layui-form-checked')
                        })

                        checkbox()
                        delclick()
                        allot()
                    }
                });
            }
        })
    });
}

function delclick() {
    $('.del').click(function () {
        var id = $(this).attr('data-id')
        var url = '/admin/Classinfo/delClassStu'
        del(url, id)
    })
}

function delAllClick() {
    $('#delAll').click(function () {
        var delurl = '/admin/Classinfo/delClassStu'
        delAll(delurl);
    })
}
function allot() {
    $('.addTch').change(function () {
        var select = $(this).val();
        var class_id = $(this).parent().attr('data-id')

        layui.use('laypage', function () {
            var laypage = layui.laypage;
            $.ajax({
                type: "post",
                url: '/admin/Classlist/allotTch',
                traditional: true,
                dataType: "json",
                data: {"classtch_id": select, "class_id": class_id},
                success: function (data) {
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
                            time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        });
                    }
                }
            })
        });
    })

}


function showData(data) {
    var authority = $('#authority').val()
    var data_html = ""
    if (!data.length > 0) {
        $("#tbody").append('<td colspan="8" style="text-align: center;"> 暂时没有数据 </td>');
    } else {
        var grade = $('#grade').val();
        if (authority != 3) {
            $.each(data, function (index, array) {
                data_html += `<tr>
                                            <td>
                                        <div class="checkbox layui-unselect layui-form-checkbox" lay-skin="primary" data-id="` + array['stu_id'] + `"><i class="layui-icon">&#xe605;</i></div>
                                        </td>
                                        <td>` + array['stu_number'] + `</td>
                                        <td>` + array['stu_name'] + `</td>
                                        <td>` + array['stu_sex'] + `</td>
                                        <td>` + array['stu_identity'] + `</td>
                                        <td>` + array['stu_dormnumber'] + `</td>
                                        <td>` + array['stu_phone'] + `</td>
                                        <td class="td-manage">
                                         <a title="查看学生信息" href="/admin/ClassInfo/stuInfo?stu_id=` + array['stu_id'] + `">
                                        <span class="layui-badge-rim layui-bg-blue">查看学生信息</span>                                          </a>
                                            <a title="编辑学生信息" href="/admin/Classinfo/editClassStu?stu_id=` + array['stu_id'] + `&class_id=` + array['class_id'] + `">
                                            <span class="layui-badge-rim layui-bg-orange">编辑学生信息</span>  
                                          </a>
                                              <a title="删除" class="del" data-id="` + array['stu_id'] + `" href="javascript:;">
                                            <span class="layui-badge">删除</span>  
                                          </a>
                                            </td>
                                        </tr>`;
            });
        } else {
            $.each(data, function (index, array) {
                data_html += `<tr>
                                            <td>
                                        <div class="checkbox layui-unselect layui-form-checkbox" lay-skin="primary" data-id="` + array['stu_id'] + `"><i class="layui-icon">&#xe605;</i></div>
                                        </td>
                                        <td>` + array['stu_number'] + `</td>
                                        <td>` + array['stu_name'] + `</td>
                                        <td>` + array['stu_sex'] + `</td>
                                        <td>` + array['stu_identity'] + `</td>
                                        <td>` + array['stu_dormnumber'] + `</td>
                                        <td>` + array['stu_phone'] + `</td>
                                        <td class="td-manage">
                                         <a title="查看学生信息" href="/admin/ClassInfo/stuInfo?stu_id=` + array['stu_id'] + `">
                                        <span class="layui-badge-rim layui-bg-blue">查看学生信息</span>   
                                          </a>
                                            </td>
                                        </tr>`;
            });
        }
    }
    return data_html;
}

