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
                    layer.close(layer.index);
                    layer.load()
                },
                success: function (res) {
                    layer.close(layer.index);
                    console.log(res)
                    if (res['valid'] == 1) {

                        if (res.msg.result != 0) {
                            layer.alert("已驳回学生信息,但通知发送不成功," + res.msg.errmsg, function(index){
                                layer.close(index);
                                location.reload();
                            });
                        }

                        if (res['msg'].detail[0]['result'] != 0) {
                            if (noticeFlag == 'infoBug') {
                                layer.alert("已驳回学生信息,但"+res['msg'].detail[0]['errmsg']+",通知发送不成功", function(index){
                                    layer.close(index);
                                    // javascript:history.back(-1)
                                    location.reload();
                                });
                            } else {
                                layer.alert(res['msg'].detail[0]['errmsg']+",通知发送不成功", function(index){
                                    layer.close(index);
                                    location.reload();
                                });
                            }
                            
                        } else {

                            if (noticeFlag == 'infoBug') {
                                 layer.alert("已驳回学生信息，已将通知发送至学生", function(index){
                                    layer.close(index);
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
