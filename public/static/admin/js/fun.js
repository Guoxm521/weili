
// 基于layui添加删除修改操作
/*
    * 添加按钮事件 需要传入数据有  title/area/content/scroll
    * 修改事件也可传入这个模块
    * 添加和修改是同一个页面
    * */
function add(title,area,content,scroll) {
    if(scroll !== true) {
        scroll = 'no'
    };
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
}
function edit() {
    //iframe窗
    layer.open({
        type: 2,
        title: "类别修改",
        closeBtn: 1, //不显示关闭按钮
        shadeClose: true,
        area: ["500px", "215px"],
        offset: ["100px"],
        anim: 2,
        content: ["./add.html", "no"], //iframe的url，no代表不显示滚动
    });
}

function del() {
    layer.confirm(
        "您确定删除吗？",
        {
            btn: ["确定", "取消"], //按钮
        },
        function () {
            layer.msg("的确很重要", { icon: 1 });
        },
        function () {
            layer.msg("也可以这样", {
                time: 20000, //20s后自动关闭
                btn: ["明白了", "知道了"],
            });
        }
    );
}