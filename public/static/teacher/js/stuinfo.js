$(function () {
    stuinfoNotice()
    editInfo()
})

var stuinfoNotice = function () {
    $('#stuinfoNotice').click(function () {
        var stu_id = $('#stu_id').val()

        layer.confirm("你确定要回学生信息，并通知学生吗？", function (index) {
            $.ajax({
                type: "post",
                url: '/teacher/Classinfo/stuinfoNotice',
                traditional: true,
                dataType: "json",
                data: {'stu_id': stu_id},
                beforeSend:function(XMLHttpRequest){
                    layer.close(layer.index);
                    layer.load()
                },
                success: function (res) {
                    console.log(res)
                    layer.close(layer.index);
                    if (res['valid'] == 1) {
                        if (res['msg'].detail[0]['result'] != 0) {
                            layer.alert("已驳回学生信息,但"+res['msg'].detail[0]['errmsg']+",通知发送不成功", function(index){
                                layer.close(index);
                                javascript:history.back(-1)
                            });
                        } else {
                            layer.alert("已驳回学生信息，已将通知发送至学生", function(index){
                                layer.close(index);
                                javascript:history.back(-1)
                            });
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
        if ($(this).html() == '<span class="layui-badge">还未填写</span>') {

            var name = $(this).attr('data-name')
            $(this).empty()

            $(this).append('<input class="layui-input input" style="width: 20%;display: inline-block;height: 25px;"></input>')
            $(this).children().focus()

            var span = $(this)

            $('.input').blur(function(){
                var stu_id = $('#stu_id').val()
                var val = $(this).val()

                $(".input").remove()

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
                                    span.append(`<span>`+val+`<span>`)
                                }
                            });
                        } else {
                            layer.msg(res['msg'], {
                                icon: 2, //提示的样式
                                time: 600,
                                end: function(){
                                    span.append(`<span class="layui-badge">还未填写</span>`)
                                }
                            });
                        }

                    }
                })
            })
        }

    })

}
