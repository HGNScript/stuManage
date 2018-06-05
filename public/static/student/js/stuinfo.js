$(function () {

    stuInfoSubmit()
    $('#stuInfoKeep').click(function () {
        stuInfoKeep()
    })

    // setInterval(function(){
    //     var info = $("#stuInfoForm").serialize();
    //     $.ajax({
    //         type: "post",
    //         url: '/student/Stuinfo/stuInfoKeep',
    //         traditional: true,
    //         dataType: "json",
    //         data: info,
    //     });
    // }, 2000)


    var stu_infoflag = $('#stu_infoflag').val()
    if (stu_infoflag != 0) {

        $('input').attr('disabled', 'disabled')
        $('.submit').attr('disabled', 'disabled')
    } else {
        layui.use('upload', function () {
            var upload = layui.upload;

            //执行实例
            var uploadInst = upload.render({
                elem: '#upload',
                url: '/student/Stuinfo/upload',
                accept: 'images',
                field: 'images',
                done: function (res) {
                    $('#img_url').val(res['url'])
                    $('#upload').empty()
                    $('#upload').append(`<img src="`+res['url']+`" style="display: inline-block;width: 100%;height: 100%;" id="img">`)
                },
            });
        });
    }


})

function stuInfoKeep() {
    var info = $("#stuInfoForm").serialize();
    $.ajax({
        type: "post",
        url: '/student/Stuinfo/stuInfoKeep',
        traditional: true,
        dataType: "json",
        data: info,
        success: function (data) {
            if (data['valid']) {
                // location.href='/index';
                layer.msg(data['msg'], {
                    icon: 1, //提示的样式
                    time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function () {
                        location.reload();
                    }
                });
            } else {
                layer.msg(data['msg'], {
                    icon: 2, //提示的样式
                    time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                });
            }
        }
    });
}


function stuInfoSubmit() {
    $('#stuInfoSubmit').click(function () {
        var info = $("#stuInfoForm").serialize();

        layer.confirm('确定要提交吗，提交后将不可更改', function (index) {
            $.ajax({
                type: "post",
                url: '/student/Stuinfo/stuInfoKeep?stu_infoflag=1',
                traditional: true,
                dataType: "json",
                data: info,
                success: function (data) {
                    if (data['valid']) {
                        // location.href='/index';
                        layer.msg(data['msg'], {
                            icon: 1, //提示的样式
                            time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                            end: function () {
                                location.reload();
                            }
                        });
                    } else {
                        layer.msg(data['msg'], {
                            icon: 2, //提示的样式
                            time: 700, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        });
                    }
                }
            });
        });

    })
}