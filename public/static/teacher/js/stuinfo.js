$(function () {
    stuinfoNotice()
    editInfo()
})

var stuinfoNotice = function () {
    $('.stuinfoNotice').click(function () {
        var stu_id = $('#stu_id').val()
        var noticeFlag = $(this).attr('data-noticeFlag')

        layer.confirm("你确定要驳回学生信息，并通知学生吗？", function (index) {
            $.ajax({
                type: "post",
                url: '/teacher/Classinfo/stuinfoNotice?noticeFlag='+ noticeFlag,
                traditional: true,
                dataType: "json",
                data: {'stu_id': stu_id},
                beforeSend:function(XMLHttpRequest){
                    // layer.close(layer.index);
                    layer.load()
                },
                success: function (res) {
                    layer.close(layer.index);
                    if (res['valid'] == 1) {

                        if (res.msg.result != 0) {
                            layer.alert("已驳回学生信息,但通知发送不成功," + res.msg.errmsg, function(index){
                                layer.close(index);
                                notice()
                                location.reload();
                            });
                        }

                        if (res['msg'].detail[0]['result'] != 0) {
                            if (noticeFlag == 'infoBug') {
                                layer.alert("已驳回学生信息,但"+res['msg'].detail[0]['errmsg']+",通知发送不成功", function(index){
                                    layer.close(index);
                                    // javascript:history.back(-1)
                                    notice()
                                    location.reload();
                                });
                            } else {
                                layer.alert(res['msg'].detail[0]['errmsg']+",通知发送不成功", function(index){
                                    layer.close(index);
                                    notice()
                                    location.reload();
                                });
                            }
                            
                        } else {

                            if (noticeFlag == 'infoBug') {
                                 layer.alert("已驳回学生信息，已将通知发送至学生", function(index){
                                    layer.close(index);
                                    notice()
                                    location.reload();
                                });
                            } else {
                                layer.alert("已通知学生填写信息", function(index){
                                    layer.close(index);
                                    location.reload();
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


var editInfo = function () {
    $('.dbclick').dblclick(function(){
        // if ($(this).html() == '还未填写') {

            var name = $(this).attr('data-name')
            var val = $(this).html()

            var parent = $(this).parent()
            $(this).remove()



            parent.append('<input class="layui-input" id="input" style="width: 25%;display: inline-block;height: 25px;" value="'+val+'">')
            parent.children().focus()

            var span = $(this)

            $('#input').blur(function(){
                var stu_id = $('#stu_id').val()
                var val = $(this).val()

                $("#input").remove()

                $.ajax({
                    type: "post",
                    url: '/teacher/Classinfo/dbClickEdit?stu_id=' + stu_id,
                    traditional: true,
                    dataType: "json",
                    data: {'name': name, 'val' : val},
                    success: function(res) {
                        if (res['valid']) {
                            layer.msg(res['msg'], {
                                icon: 1, //提示的样式
                                time: 600,
                                end: function(){
                                    parent.append(`<span>`+val+`<span>`)
                                    location.reload()

                                }
                            });
                        } else {
                            layer.msg(res['msg'], {
                                icon: 2, //提示的样式
                                time: 600,
                                end: function(){
                                    // parent.append(`<span class="dbclick layui-badge" data-name="stu_originaltroops">还未填写</span>`)
                                    location.reload()
                                }
                            });
                        }

                    }
                })
            })
        // }

    })

}

var notice = function (){
    var class_id = $('#class_id').val()
    console.log(class_id)
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

            parent.$(".grant").each(function(i){
                var _this = $(this)
                var class_name = $(this).parents("ul").prev().children('cite').html()

                if (data['class_name'] == class_name) {
                    if (data['grant']) {

                        parent.$('.layui-this').find("span").replaceWith(`<span class="layui-badge">`+data['grant']+`</span>`)

                        _this.html('')
                        _this.html('助学金申请&nbsp;&nbsp;&nbsp;<span class="layui-badge">'+data['grant']+'</span>')

                    } else {

                        parent.$('.layui-this').find("span").remove()

                        _this.html('')
                        _this.html('助学金申请')
                    }
                }
            });

            javascript:history.back(-1)

        }
    });
}
