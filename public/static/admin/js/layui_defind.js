layui.define(["jquery", "layer", "form"], function (exports) {
    //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
    var $ = layui.jquery;
    var layer = layui.layer;
    var form = layui.form;
    var obj = {
        hello: function (str) {
            alert("Hello " + (str || "mymod"));
        },
        // 分页功能
        page: function (count,limit,curr,search) {
            layui.use("laypage", function () {
                const laypage = layui.laypage;
                laypage.render({
                    elem: "page",
                    limit:limit,
                    count: count,
                    curr:curr,
                    jump: function (obj, first) {
                        if(!first){
                            if(search) {
                                console.log(1)
                                location.href="?page="+obj.curr+"&limit="+obj.limit+search;
                            }else {
                                console.log(2);
                                location.href="?page="+obj.curr+"&limit="+obj.limit;
                            }

                        }
                    },
                });
            });
        },
        /*
        * 添加按钮事件 需要传入数据有  title/area/content/scroll
        * 修改事件也可传入这个模块
        * 添加和修改是同一个页面
        * */
        add: function (title, area, content, scroll) {
            if (scroll !== true) {
                scroll = 'no'
            }
            ;
            layer.open({
                type: 2,
                title: title,
                closeBtn: 1,
                shadeClose: true,
                area: area,//["500px", "215px"]
                offset: ["100px"],
                anim: 2,
                content: [content, scroll], //iframe的url，no代表不显示滚动
            });
        },
        /*
        * 删除按钮事件 根据传入的条件删除
        * 传入的值有 data url
        * 返回一个json对象
        * */
        delete: function (data, url) {
            layer.confirm(
                "您确定删除吗？",
                {
                    btn: ["确定", "取消"], //按钮
                },
                function () {
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        success: function (res) {
                            /*
                            * code =1 可以删除
                            * code =2 该类别已经存在，无法删除
                            * */
                            if (res.code == 1) {
                                location.reload();
                                parent.layer.closeAll();
                                layer.msg(res.msg, {icon: 1, time: 2000});
                            } else if (res.code == 2) {
                                layer.msg(res.msg, {icon: 2, time: 1000})
                            }
                        }
                    })

                },
                function () {
                    parent.layer.closeAll();
                }
            );
        },
        // 修改事件按钮事件 小添加页面  运用弹窗的效果
        edit: function () {
            layer.open({
                type: 2,
                title: "类别修改",
                closeBtn: 1, //不显示关闭按钮
                shadeClose: true,
                area: ["500px", "700px"],
                offset: ["100px"],
                anim: 2,
                content: ["./add.html", "no"], //iframe的url，no代表不显示滚动
            });
        },
        // 给获取内容按钮注册事件
        get_content: function (url,area) {
            if (!area) {
                area = ["600px", "500px"];
            }
            ;
            $(".get_content").on("click", function () {
                const id = $(this).attr('data-id');
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (res) {
                        layer.open({
                            type: 1,
                            title:res[0].sortname,
                            closeBtn: 1,
                            skin: "layui-layer-rim", //加上边框
                            area: area, //宽高
                            content:res[0].content
                            // "<img src='./../src/ia_200000017.jpg'>",
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        },
        // 发布按钮注册事件
        publish: function (url) {
            $("span[class^=check]").on("click", function () {
                const publish = $(this).attr('value');
                const id = $(this).attr('data-id');
                if ($(this).attr("class") == "check_yes") {
                    $(this)
                        .removeClass("check_yes")
                        .addClass("check_no")
                        .html("<i class='layui-icon layui-icon-close'></i>否");
                } else {
                    $(this)
                        .removeClass("check_no")
                        .addClass("check_yes")
                        .html("<i class='layui-icon layui-icon-ok'></i>是");
                }
                $.ajax({
                    type:'post',
                    url:url,
                    data:{
                        publish:publish,
                        id:id
                    },
                    success:function () {
                        location.reload();
                    },
                    error:function (error) {
                        console.log(error);
                    }
                })
            });
        },
        //获取页面URL的值
        geturl: function () {
            const param = {};
            const query = window.location.search.substr(1);
            const url = query.split('&');
            for (var i = 0, l = url.length; i < l; i++) {
                const a = url[i].split('=');
                param[a[0]] = a[1];
            }
            return param;
        },
        /*
        * 选择文件后对图片进行展示
        * 传入文件的类型数组 typeArr
        * 判断是否图片  isImg
        * */
        showimg: function (typeArr, isImg) {
            if (!typeArr) {
                typeArr = ['jpg', 'jpeg', 'png'];
            }
            ;
            if (isImg == null) {
                isImg = true
            }
            $("input[type='file']").on('change', function () {
                const files = $(this)[0].files;
                $("#img_box").empty();
                for (var i = 0; i < files.length; i++) {
                    const name = files[i].name;
                    const type = name.substr(name.lastIndexOf(".") + 1);
                    // 判断文件格式
                    if (typeArr.indexOf(type) == -1) {
                        layer.msg("请传入正确的文件格式");
                        return false;
                    }
                    ;
                    //上传的是图片的话
                    if (isImg) {
                        const reader = new FileReader();
                        reader.readAsDataURL(files[i]);
                        reader.onload = function () {
                            const src = this.result;
                            $("#img_box").append("<img id='upload_img_show' class='upload_img_show'>")
                            $("#upload_img_show").attr('src', this.result);
                            $("#upload_img_show").removeAttr('id');
                        };
                    } else {
                        $('#img_box').html("<img src=''/>");
                        $('#img_box').children('img').attr('src', '/static/admin/images/ia.jpg')
                    }

                }
            })
        },
        /*
        * 获取页面的选项框
        * */
        getoption: function (url,type) {
            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                success: function (res) {
                    let str = '';
                    for (let i = 0; i < res.length; i++) {
                        str += "<option data-id=" + res[i].id + " value=" + res[i].sortname + ">" + res[i].sortname + "</option>";
                    }
                    $("#sortname").append(str);
                    if(type == 'add') {
                        form.render();
                    }
                }
            })
        },
        /*
        * 数据添加发送ajax请求
        * 处理关于我们，这种有多图片上传
        * */
        addfiles: function (upurl, formData, jumpurl) {
            $.ajax({
                type: 'post',
                url: upurl,
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (res) {
                    layer.msg(1)
                    layer.msg(res.msg)
                    if (res.code == 1) {
                        location.href = jumpurl;
                    }
                },
                error: function (res) {
                    layer.msg(res.msg)
                }
            })
        }
    };

    //输出test接口
    exports("layui_defind", obj);
});
