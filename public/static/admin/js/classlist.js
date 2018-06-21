var pageData = null;
$(function () {
    page(null);

    var excelurl = '/admin/Classlist/excelAddClasslist?staffRoom=';
    excel(excelurl);


    delAllClick()
    search()


})

function page(search) {
    var staffRoom = $('#staffRoom').val()
    var grade = $('#grade').val()
    layui.use('laypage', function () {
        var laypage = layui.laypage;
        var data = {'curr': null, 'limit': null, 'staffRoom': staffRoom, 'search': search, 'grade': grade};
        $.ajax({
            type: "post",
            url: '/admin/classlist/index',
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
        var url = '/admin/Classlist/delClasslist'
        del(url, id)
    })
}

function delAllClick() {
    $('#delAll').click(function () {
        var delurl = '/admin/Classlist/delClasslist'
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
                            time: 1500, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        });
                    }
                }
            })
        });
    })

}

function showData(pageData) {
    var authority = $('#authority').val()
    var data_html = ""

    if (!pageData.length > 0) {
        $("#tbody").append('<td colspan="7" style="text-align: center;"> 暂时没有数据 </td>');
    } else {
        var grade = $('#grade').val();
        if (authority != 3) {
            $.each(pageData, function (index, array) {
                data_html += `<tr>
                                                <td>
                                                <div class="checkbox layui-unselect layui-form-checkbox" lay-skin="primary" data-id="` + array['class_id'] + `"><i class="layui-icon">&#xe605;</i></div>
                                                </td>
                                                <td>` + array['class_grade'] + `</td>
                                                <td>` + array['class_name'] + `</td>
                                                <td>` + array['class_staffRoom'] + `</td>
                                                <td>` + array['class_specialty'] + `</td>
                                                <td data-id="` + array['class_id'] + `" style="width: 20%">` + array['classtch_name'] + `</td>
                                                <td class="td-manage">
                                                 <a title="查看班级信息" href="/admin/ClassInfo/index?class_id=` + array['class_id'] + `&staffRoom=` + array['class_staffRoom'] + `&grade=` + array['class_grade'] + `">
                                                <span class="layui-badge-rim layui-bg-blue">查看班级信息</span>  
                                              </a>
                                                <a title="编辑班级信息" href="/admin/Classlist/editClasslist?class_id=` + array['class_id'] + `&staffRoom=` + array['class_staffRoom'] + `&grade=` + array['class_grade'] + `">
                                                <span class="layui-badge-rim layui-bg-orange">编辑班级信息</span> 
                                              </a>
                                                      <a title="删除" class="del" data-id="` + array['class_id'] + `" href="javascript:;">
                                                    <span class="layui-badge">删除</span>  
                                                  </a>
                                                  </a>
                                                     <a class="layui-btn layui-btn-small export"  href="/admin/Classlist/export?class_id=` + array['class_id'] + `" title="导出班级数据">
                                                    导出班级数据</a>
                                                    </td>
                                                </tr>`;
            });
        } else {
            $.each(pageData, function (index, array) {
                data_html += `<tr>
                                                <td>
                                                <div class="checkbox layui-unselect layui-form-checkbox" lay-skin="primary" data-id="` + array['class_id'] + `"><i class="layui-icon">&#xe605;</i></div>
                                                </td>
                                                <td>` + array['class_grade'] + `</td>
                                                <td>` + array['class_name'] + `</td>
                                                <td>` + array['class_staffRoom'] + `</td>
                                                <td>` + array['class_specialty'] + `</td>
                                                <td data-id="` + array['class_id'] + `" style="width: 20%">` + array['classtch_name'] + `</td>
                                                <td class="td-manage">
                                                 <a title="查看班级信息" href="/admin/ClassInfo/index?class_id=` + array['class_id'] + `&staffRoom=` + array['class_staffRoom'] + `&grade=` + array['class_grade'] + `">
                                                <span class="layui-badge-rim layui-bg-blue">查看学生信息</span>
                                              </a>
                                                  </a>
                                                     <a class="layui-btn layui-btn-small export"  href="/admin/Classlist/export?class_id=` + array['class_id'] + `" title="导出班级数据">
                                                    导出班级数据</a>
                                                    </td>
                                                </tr>`;
            });
        }
    }

    return data_html;
}
