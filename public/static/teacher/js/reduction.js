$(function () {
    examine()
    $('.print').click(function () {
        doPrint()
    })

    $('#search').click(function () {
        search()
    })
    $('#input').keypress(function (event) {
        var keynum = (event.keyCode ? event.keyCode : event.which);
        if (keynum == '13') {
            search()
        }
    });

    layui.use('form', function () {
        var form = layui.form;
        form.on('select(test)', function (data) {
            search()
        });
    });
})

var notice = function () {
    var class_id = $('#class_id').val()
    console.log(class_id)
    $.ajax({
        type: "get",
        url: '/teacher/Index/classNotice?class_id=' + class_id,
        traditional: true,
        dataType: "json",
        beforeSend: function (XMLHttpRequest) {
            layer.close(layer.index);
            layer.load()
        },
        success: function (data) {

            parent.$(".reduction").each(function (i) {
                var _this = $(this)
                var class_name = $(this).parents("ul").prev().children('cite').html()

                if (data['class_name'] == class_name) {
                    if (data['reduction']) {

                        parent.$('.layui-this').find("span").replaceWith(`<span class="layui-badge">` + data['reduction'] + `</span>`)

                        _this.html('')
                        _this.html('免学费申请&nbsp;&nbsp;&nbsp;<span class="layui-badge">' + data['reduction'] + '</span>')

                    } else {

                        parent.$('.layui-this').find("span").remove()

                        _this.html('')
                        _this.html('免学费申请')
                    }
                }
            });

            javascript:history.back(-1)

        }
    });
}

var examine = function () {
    $('.examine').click(function () {
        var reduction_flag = $(this).attr('data-reduction_flag')
        var reduction_id = $('#reduction_id').val()
        var msg = ''

        if (reduction_flag == 2) {
            msg = '确定该文件审查通过，并通知学生吗'
        } else {
            msg = '确定该文件审查不通过，并通知学生吗，'
        }

        layer.confirm(msg, function (index) {
            $.ajax({
                type: "post",
                url: '/teacher/Reduction/examineRequest',
                traditional: true,
                dataType: "json",
                data: {'reduction_flag': reduction_flag, 'reduction_id': reduction_id},
                beforeSend: function (XMLHttpRequest) {
                    layer.close(layer.index);
                    layer.load()
                },
                success: function (res) {
                    layer.close(layer.index);
                    if (res['valid'] == 1) {

                        if (res['msg'].result == 0) {
                            if (reduction_flag == 2) {

                                if (res['msg'].detail[0]['result'] != 0) {
                                    layer.alert("已通过免学费申请,但" + res['msg'].detail[0]['errmsg'] + ",通知发送不成功", function (index) {
                                        layer.close(index);
                                        notice()
                                    });
                                } else {
                                    layer.alert("已通过免学费申请，已将通知发送至学生", function (index) {
                                        layer.close(index);
                                        notice()
                                    });
                                }
                            } else {

                                if (res['msg'].detail[0]['result'] != 0) {
                                    layer.alert("未通过免学费申请," + res['msg'].detail[0]['errmsg'] + "通知发送不成功", function (index) {
                                        layer.close(index);
                                        notice()
                                    });

                                } else {
                                    layer.alert("未通过免学费申请，已将通知发送至学生", function (index) {
                                        layer.close(index);
                                        notice()
                                    });

                                }
                            }
                        } else {
                             if (res.msg.result != 0) {
                                 if (reduction_flag == 2) {
                                    layer.alert("已通过免学费申请,但通知发送不成功," + res.msg.errmsg, function(index){
                                        layer.close(index);
                                        location.reload();
                                    });
                                } else {
                                    layer.alert("未通过免学费申请,但通知发送不成功," + res.msg.errmsg, function(index){
                                        layer.close(index);
                                        location.reload();
                                    });
                                }

                            } else {
                                layer.msg("服务器出现错误")
                                
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


function doPrint() {
    var head_str = "<html><head><title></title></head><body>"; //先生成头部
    var foot_str = "</body></html>"; //生成尾部
    var older = document.body.innerHTML;
    var new_str = document.getElementById('pc').innerHTML; //获取指定打印区域
    var old_str = document.body.innerHTML; //获得原本页面的代码
    document.body.innerHTML = head_str + new_str + foot_str; //构建新网页
    window.print(); //打印刚才新建的网页
    document.body.innerHTML = old_str; //将网页还原
    $('.print').click(function () {
        doPrint()
    })
    return false;
}

function search() {
    var search = $('#input').val()
    var class_id = $('#class_id').val()
    var reduction_flag = $('#reduction_flag').val()
    var month = $('#month').val();

    if (!search && !month) {
        layer.msg('输入你要查询的数据或月份', {
            time: 1000,
            end: function (){
                location.reload()
            }

        })
        return 0
    }
    $.ajax({
        type: "post",
        url: '/teacher/Reduction/search',
        traditional: true,
        dataType: "json",
        data: {'reduction_flag': reduction_flag, 'search': search, 'class_id': class_id, 'month': month},
        beforeSend: function () {
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
            $.each(data, function (index, array) {
                data_html += `<li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title">` + array['update_time'] + `</h3>
                        <a href="/teacher/Reduction/examine?reduction_id=` + array['reduction_id'] + `">
                            <p style="border: 1px solid #c0ced3; display: inline-block;padding: 10px;width:40%; border-radius: 5px">
                                申请人： ` + array['stu_name'] + `
                                <br>申请人学号： ` + array['stu_number'] + `
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