
// 基于layui添加删除修改操作
function add() {
    //iframe窗
    layer.open({
        type: 2,
        title: "类别添加",
        closeBtn: 1, //不显示关闭按钮
        shadeClose: true,
        area: ["500px", "215px"],
        offset: ["100px"],
        anim: 2,
        content: ["./add.html", "no"], //iframe的url，no代表不显示滚动
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