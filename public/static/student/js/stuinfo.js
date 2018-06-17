var v = null
$(function () {
    top()
    eachShow()
    stuInfoSubmit()
    retiredsoldier()
    noBlur()
    identity()

    $('#birthday').css({"borderColor": "#5FB878"})


    $('#stuInfoKeep').click(function () {
        stuInfoKeep()
    })

    function noBlur(){
        $('.definite').blur(function(){
            var _this = $(this)
            showBorder(_this);
        })
    }
    

    layui.use('laydate', function(){
        var laydate = layui.laydate;
          //执行一个laydate实例
        laydate.render({
          elem: '#birthday',
          done: function(value, date, endDate){ //监听日期被切换
            if (!value) {
                $('#birthday').css({"borderColor": "#FF0000"})
            } else {
                $('#birthday').css({"borderColor": "#5FB878"})
            }
          }
        })
    })

    v = $('.stu_dormnumber').val()
    layui.use('form', function(){
        var form = layui.form;
      
        form.on('radio(stu_dormFlag)', function(data){
            var obj = $('.stu_dormnumber')
            selectStyle(obj, data)
        });


        form.on('radio(stu_retiredsoldier)', function(data){
            var obj = $('.stu_retiredsoldier')

            if (data.value == '否') {

                $('#enlisttime').attr({disabled: 'disabled'})
                $('#demobilizedtime').attr({disabled: 'disabled'})
                obj.attr({disabled: 'disabled'})
                obj.removeAttr("style")
                obj.attr({borderColor: '1px solid #ccc'})
                obj.val('请选择是否退役士兵后在填写')

                $('.retiredsoldierTime').removeAttr("style")

                $('.retiredsoldierTime').css({"borderColor":'1px solid #ccc'}) 

                $('.retiredsoldierTime').val('');


            } else {
                $('#enlisttime').removeAttr("disabled")
                $('#demobilizedtime').removeAttr("disabled")
                $('#enlisttime').css({"borderColor": "#FF0000"})
                $('#demobilizedtime').css({"borderColor": "#FF0000"}) 

                obj.addClass('definite')
                obj.removeAttr("disabled")
                obj.val('')
                noBlur()
                eachShow()
                time()
            }
        });
    });

    function retiredsoldier(){

        var flag = $('#stu_retiredsoldier').val()
        var obj = $('.stu_retiredsoldier')

        if (flag == '否') {
            obj.attr({disabled: 'disabled'})
            obj.val('请选择是否退役士兵后在填写')

            $('#enlisttime').attr({disabled: 'disabled'})
            $('#demobilizedtime').attr({disabled: 'disabled'}) 
            
            $('.retiredsoldierTime').removeAttr("style")

            $('.retiredsoldierTime').css({"borderColor": '1px solid #ccc'})

            $('.retiredsoldierTime').val('');

        } else {
            obj.addClass('definite')
            eachShow()
            time()
            noBlur()
            

        }
    }


    

    var stu_infoflag = $('#stu_infoflag').val()

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


    function topInitia() {
        var windowH = $(window).height();
        var topHW = 40;
        $('#top').css({
            'width': topHW + 'px',
            'height': topHW + 'px',
            'display': 'none',
            'position': 'fixed',
            'right': (topHW / 2),
            'top': windowH - topHW - (topHW / 2)-50,
            'border-radius': '5px',
        })
    }

    function top() {
        topInitia();

        $(window).resize(function() {
            topInitia();
        })
        //返回顶部
        $(window).scroll(function() {
            if ($(window).scrollTop() > 100) {
                $('#top').fadeIn(1000);
            } else {
                $('#top').fadeOut(1000);
            }
        })

        $('#top').click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 600);
            return false;
        })

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
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                    end: function () {
                        location.reload();
                    }
                });
            } else {
                layer.msg(data['msg'], {
                    icon: 2, //提示的样式
                    time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
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
                            time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                            end: function () {
                                location.reload();
                            }
                        });
                    } else {
                        layer.msg(data['msg'], {
                            icon: 2, //提示的样式
                            time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        });
                    }
                }
            });
        });

    })
}

function showBorder(_this) {
    var value = _this.val();
    if (!value) {
        _this.css({"border-color": "#FF0000"})
    } else {
        _this.css({"border-color": "#5FB878"})
    }
}

function eachShow(){
    $('.definite').each(function(){
        showBorder($(this))
    })

    $('.retiredsoldierTime').each(function(){
        showBorder($(this))
    })
}


function selectStyle(obj, data){
    if (data.value == '否') {
        obj.attr({disabled: 'disabled'})
        obj.removeAttr("style")
        obj.attr({borderColor: '1px solid #ccc'})
        obj.val('请选择是否住宿后在填写')

    } else {

        obj.addClass('definite')
        obj.removeAttr("disabled")
        obj.val(v)
        eachShow()

    }
}

function time() {
    layui.use('laydate', function(){
        var laydate = layui.laydate;
          //执行一个laydate实例
        laydate.render({
          elem: '#enlisttime',
          done: function(value, date, endDate){ //监听日期被切换
            if (!value) {
                $('#enlisttime').css({"borderColor": "#FF0000"})
            } else {
                $('#enlisttime').css({"borderColor": "#5FB878"})
            }
          }
        })

        laydate.render({
          elem: '#demobilizedtime',
          done: function(value, date, endDate){ //监听日期被切换
            if (!value) {
                $('#demobilizedtime').css({"borderColor": "#FF0000"})
            } else {
                $('#demobilizedtime').css({"borderColor": "#5FB878"})
            }
          }
        })
    })
}

function identity (){

    var UUserCard = $('#stu_identity').val() 
    //获取出生日期 
    var stu_birthday= UUserCard.substring(6, 10) + "." + UUserCard.substring(10, 12) + "." + UUserCard.substring(12, 14)

    $('#stu_birthday').val(stu_birthday)

    $('#stu_identity').keydown(function(){
        var UUserCard = $(this).val() 
        //获取出生日期 
        var stu_birthday= UUserCard.substring(6, 10) + "." + UUserCard.substring(10, 12) + "." + UUserCard.substring(12, 14)

        $('#stu_birthday').val(stu_birthday)
    })

    $('#stu_identity').blur(function(){
        var UUserCard = $(this).val() 
        //获取出生日期 
        var stu_birthday= UUserCard.substring(6, 10) + "." + UUserCard.substring(10, 12) + "." + UUserCard.substring(12, 14)

        $('#stu_birthday').val(stu_birthday)
    })
}


