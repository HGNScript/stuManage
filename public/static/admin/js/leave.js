/**
 * Created by HGN on 2018/7/20.
 */
var class_id = null
$(function () {
    class_id = $('#class_id').val()
    examine()
    $('#search').click(function(){
        search()
    })

    $('#input').keypress(function (event) {
        var keynum = (event.keyCode ? event.keyCode : event.which);
        if (keynum == '13') {
            search()
        }
    });

    layui.use('form', function(){
        var form = layui.form;
        form.on('select(test)', function(data){
            search()
        });
    });

})

var notice = function (){
    var leave_flag_top = $('#leave_flag_top').val()

    $.ajax({
        type: "get",
        url: '/teacher/Index/classNotice?leave_flag_top=' + leave_flag_top,
        traditional: true,
        dataType: "json",
        beforeSend:function(XMLHttpRequest){
            index = layer.load()
        },
        success: function(data) {
            layer.close(layer.index);
            parent.$(".leave").each(function(i){
                var _this = $(this)
                var class_name = $(this).parents("ul").prev().children('cite').html()
                    if (data['leave']) {
                        parent.$('.layui-this').find("span").replaceWith(`<span class="layui-badge">`+data['leave']+`</span>`)
                        _this.html('')
                        _this.html('请假申请&nbsp;&nbsp;&nbsp;<span class="layui-badge">'+data['leave']+'</span>')

                    } else {
                        parent.$('.layui-this').find("span").remove()

                        _this.html('')
                        _this.html('请假申请')
                    }
            });

            location.href='/admin/Leave/index?leave_flag_top=' + leave_flag_top + '&leave_flag=1'


        }
    });
}


var examine = function () {
    $('.examine').click(function () {
        var leave_flag = $(this).attr('data-leave_flag')
        var leave_flag_top = $(this).attr('data-leave_flag_top')
        var leave_id = $('#leave_id').val()
        var msg = ''


        if (leave_flag == 2) {
            msg = '确定该文件审查通过，并通知学生吗'
        } else if (leave_flag == 3) {
            msg = '确定该文件审查不通过，并通知学生吗，'
        }

        layer.confirm(msg, function (index) {
            $.ajax({
                type: "post",
                url: '/teacher/Leave/examineRequest',
                traditional: true,
                dataType: "json",
                data: {'leave_flag': leave_flag, 'leave_id': leave_id, 'leave_flag_top': leave_flag_top},
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
                                    notice()

                                });
                            } else {
                                layer.alert("已通过请假申请，已将通知发送至学生", function(index){
                                    notice()
                                });
                            }
                        } else if(leave_flag == 3){
                            if (res['msg'].detail[0]['result'] != 0) {
                                layer.alert("未通过请假申请,"+res['msg'].detail[0]['errmsg']+"通知发送不成功", function(index){
                                    notice()
                                });

                            } else {
                                layer.alert("未通过请假申请，已将通知发送至学生", function(index){
                                    notice()
                                });

                            }
                        } else if (leave_flag_top == 4) {
                            if (res['msg'].detail[0]['result'] != 0) {
                                layer.alert("已将请假申请发送至叶科长,"+res['msg'].detail[0]['errmsg']+"通知发送不成功", function(index){
                                    notice()
                                });

                            } else {
                                layer.alert("已将请假申请发送至叶科长", function(index){
                                    notice()
                                });

                            }

                        } else if (leave_flag_top == 5) {

                            if (res['msg'].detail[0]['result'] != 0) {
                                layer.alert("已将请假申请发送至林校长,"+res['msg'].detail[0]['errmsg']+"通知发送不成功", function(index){
                                    notice()
                                });

                            } else {
                                layer.alert("已将请假申请发送至林校长", function(index){
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
    var leave_flag_top = $('#leave_flag_top').val()
    var month = $('#month').val();

    if (!search && !month) {
        layer.msg('输入你要查询的数据或月份', {
            time: 1000,
            end: function(){
                location.reload()
            }
        })
        return 0
    }
    $.ajax({
        type: "post",
        url: '/teacher/Leave/search',
        traditional: true,
        dataType: "json",
        data: {'leave_flag': leave_flag, 'search': search, 'class_id': class_id, 'month': month, 'leave_flag_top':leave_flag_top},
        beforeSend: function (){
            layer.load()
        },
        success: function (data) {
            layer.close(layer.index);
            if (!data.length > 0) {
                layer.msg('没有您查找的数据', {
                    time: 1000,
                })
            }

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
