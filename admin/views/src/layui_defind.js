layui.define(["jquery", "layer"], function (exports) {
	//提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
	var $ = layui.jquery;
	var layer = layui.layer;
	var obj = {
		hello: function (str) {
			alert("Hello " + (str || "mymod"));
		},
		// 分页功能
		page: function () {
			layui.use("laypage", function () {
				var laypage = layui.laypage;
				laypage.render({
					elem: "page",
					count: "50",
					jump: function (obj, first) {
						console.log(obj.curr);
						console.log(obj.limit);
					},
				});
			});
		},
		// 添加按钮事件
		add: function () {
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
		},
		// 删除按钮事件
		del: function () {
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
		},
		// 修改事件按钮事件
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
		get_content: function () {
			$(".get_content").on("click", function () {
				layer.open({
					type: 1,
					closeBtn: 1,
					skin: "layui-layer-rim", //加上边框
					area: ["600px", "500px"], //宽高
					content:
						"<img src='./../src/ia_200000017.jpg'>",
				});
			});
		},
		// 发布按钮注册事件
		publish: function () {
			$("span[class^=check]").on("click", function () {
				if ($(this).attr("class") == "check_yes") {
					$(this)
						.removeClass("check_yes")
						.addClass("check_no")
						.html("<i class='layui-icon layui-icon-close'></i>否");
					// TODO
					// 还需要完成AJAX请求
				} else {
					$(this)
						.removeClass("check_no")
						.addClass("check_yes")
						.html("<i class='layui-icon layui-icon-ok'></i>是");
				}
			});
		},
	};

	//输出test接口
	exports("layui_defind", obj);
});
