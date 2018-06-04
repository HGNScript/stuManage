$(function(){
    page(null);

    search()

})

function page(search) {
    var staffRoom = $('#staffRoom').val()
    var class_id = $('#class_id').val()
    layui.use('laypage', function() {
        var laypage = layui.laypage;
        var data = { 'curr': null, 'limit': null, 'staffRoom' : staffRoom, 'search' : search};
        $.ajax({
            type: "post",
            url: '/teacher/Classinfo/index?class_id='+class_id,
            traditional: true,
            dataType: "json",
            data: data,
            success: function(data) {
                var len = data
                laypage.render({
                    elem: 'test1' //注意，这里的 test1 是 ID，不用加 # 号
                    ,
                    count: len, //数据总数，从服务端得到
                    limit: 5,
                    jump: function(obj, first) {
                        //obj包含了当前分页的所有参数，比如：
                        var data = { 'curr': obj.curr, 'limit': obj.limit, 'staffRoom' : staffRoom, 'search' : search};
                        // console.log(data);
                        $.ajax({
                            type: "post",
                            url: '/teacher/Classinfo/index?class_id='+class_id,
                            traditional: true,
                            dataType: "json",
                            data: data,
                            // beforeSend: function(){
                            //     load = layer.load()
                            // },
                            success: function(data) {
                                // layer.close(load)
                                $("#tbody").empty()
                                var data_html = ""
                                if (!data.length > 0) {
                                    $("#tbody").append('<td colspan="5" style="text-align: center;"> 暂时没有数据 </td>');
                                } else {
                                    var grade = $('#grade').val();
                                    $.each(data, function(index, array) {
                                        data_html += `<tr>
                                    <td>` + array['stu_number'] + `</td>
                                    <td>` + array['stu_name'] + `</td>
                                    <td>` + array['stu_phone'] + `</td>
                                    <td class="td-manage">
                                         <a title="查看学生信息" href="/teacher/ClassInfo/stuInfo?stu_id=` + array['stu_id'] + `">
                                        <i class="layui-icon">&#xe62d;</i>
                                      </a>
                                            </td>
                                        </tr>`;
                                    });
                                }
                                $("#tbody").append(data_html);
                                $('.layui-unselect').not('.header').click(function() {
                                    $(this).toggleClass('layui-form-checked')
                                })

                                checkbox()
                            }
                        });
                    }
                });
            }
        })
    });
}



