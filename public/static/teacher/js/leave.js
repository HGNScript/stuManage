$(function () {
    examine()
    $('#search').click(function(){
        search()
    })

    $('#input').keypress(function (event) {
        console.log(1)
        var keynum = (event.keyCode ? event.keyCode : event.which);
        if (keynum == '13') {
            search()
        }
    });

})

var notice = function (){
    var class_id = $('#class_id').val()
        $.ajax({
            type: "get",
            url: '/teacher/Index/classNotice?class_id='+class_id,
            traditional: true,
            dataType: "json",
            beforeSend:function(XMLHttpRequest){
                layer.close(layer.index);
                layer.load()
            },
            success: function(data) {
                layer.close(layer.index);
                parent.$(".leave").each(function(i){
                    var _this = $(this)
                    var class_name = $(this).parents("ul").prev().children('cite').html()

                    if (data['class_name'] == class_name) {
                        if (data['leave']) {

                            parent.$('.layui-this').find("span").replaceWith(`<span class="layui-badge">`+data['leave']+`</span>`)

                            _this.html('')
                            _this.html('请假申请&nbsp;&nbsp;&nbsp;<span class="layui-badge">'+data['leave']+'</span>')

                        } else {

                            parent.$('.layui-this').find("span").remove()

                            _this.html('')
                            _this.html('请假申请')
                        }
                    }
                });

                javascript:history.back(-1)

            }
        });
    }


var examine = function () {
    $('.examine').click(function () {
        var leave_flag = $(this).attr('data-leave_flag')
        var leave_id = $('#leave_id').val()
        var msg = ''

        if (leave_flag == 2) {
            msg = '确定该文件审查通过，并通知学生吗'
        } else {
            msg = '确定该文件审查不通过，并通知学生吗，'
        }

        layer.confirm(msg, function (index) {
            $.ajax({
                type: "post",
                url: '/teacher/Leave/examineRequest',
                traditional: true,
                dataType: "json",
                data: {'leave_flag': leave_flag, 'leave_id': leave_id},
                beforeSend:function(XMLHttpRequest){
                    layer.close(layer.index);
                    layer.load()
                },
                success: function (res) {
                    layer.close(layer.index);
                    if (res['valid'] == 1) {
                        if (leave_flag == 2) {
                            if (res['msg'].detail[0]['result'] != 0) {
                                layer.alert("已通过请假申请,但"+res['msg'].detail[0]['errmsg']+",通知发送不成功", function(index){
                                    layer.close(index);
                                    notice()

                                });
                            } else {
                                layer.alert("已通过请假申请，已将通知发送至学生", function(index){
                                    layer.close(index);
                                    notice()
                                });
                            }
                        } else {
                            if (res['msg'].detail[0]['result'] != 0) {
                                layer.alert("未通过请假申请,"+res['msg'].detail[0]['errmsg']+"通知发送不成功", function(index){
                                    layer.close(index);
                                    notice()
                                });

                            } else {
                                layer.alert("未通过请假申请，已将通知发送至学生", function(index){
                                    layer.close(index);
                                    notice()
                                });

                            }
                        }
                    } else {
                        layer.msg(res['msg'])
                    }
                }
            });

        });

    })
}

function search() {
    var search = $('#input').val()
    var class_id = $('#class_id').val()
    var leave_flag = $('#leave_flag').val()
    $.ajax({
        type: "post",
        url: '/teacher/Leave/search',
        traditional: true,
        dataType: "json",
        data: {'leave_flag': leave_flag, 'search': search, 'class_id': class_id},
        success: function (data) {
            $("#ul").empty()
            var data_html = ""
            $.each(data, function(index, array) {
                data_html += `<li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title">` + array['create_time'] + `</h3>
                        <a href="/teacher/Leave/examine?leave_id=` + array['leave_id'] + `">
                            <p style="border: 1px solid #c0ced3; display: inline-block;padding: 10px;width:40%; border-radius: 5px">
                                申请人： ` + array['leave_name'] + `
                                <br>申请人联系电话： ` + array['stu_phone'] + `
                                <br>所属班级： ` + array['class_name'] + `
                            </p>
                        </a>
                    </div>
                </li>`;

            });
            $("#ul").append(data_html);

        }
    });

}
