var pageData = null;
$(function () {

    page(null);

    search()

})

function page(search) {
    var staffRoom = $('#staffRoom').val()
    var class_id = $('#class_id').val()
    layui.use('laypage', function () {
        var laypage = layui.laypage;
        var data = {'curr': null, 'limit': null, 'staffRoom': staffRoom, 'search': search};
        $.ajax({
            type: "post",
            url: '/teacher/Classinfo/index?class_id=' + class_id,
            traditional: true,
            dataType: "json",
            data: data,
            // beforeSend: function (){
            //     layer.load()
            // },
            success: function (data) {
                // layer.close(layer.index);
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
                    }
                });
            }
        })
    });
}

function showData(data) {
    var data_html = ""
    if (!data.length > 0) {
        $("#tbody").append('<td colspan="7" style="text-align: center;"> 暂时没有数据 </td>');
    } else {
        var grade = $('#grade').val();
        $.each(data, function (index, array) {
            data_html += `<tr>
                                    <td>` + array['stu_number'] + `</td>
                                    <td>` + array['stu_name'] + `</td>
                                    <td>` + array['stu_sex'] + `</td>
                                    <td>` + array['stu_identity'] + `</td>
                                    <td>` + array['stu_dormnumber'] + `</td>
                                    <td>` + array['stu_phone'] + `</td>
                                    <td class="td-manage">
                                         <a href="/teacher/ClassInfo/stuInfo?stu_id=` + array['stu_id'] + `">
                                        <span class="layui-badge-rim layui-bg-blue">查看学生信息</span>
                                      </a>
                                            </td>
                                        </tr>`;
        });
    }
    return data_html
}



