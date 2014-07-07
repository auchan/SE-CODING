<!doctype html>
<html>
	<head>
		<meta charset='gb2312'>
		<title>订单查询</title>
		<base href="../../" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
		<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
		<link rel="stylesheet" type="text/css" href="worker/admin/admin.css">
		<script type="text/javascript" src="easyui/jquery.min.js"></script>
		<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>	
	</head>
	<body class="easyui-layout">
    <!--div data-options="region:'north', split:true" style="overflow:hidden;height:60px;background-color:#eeeee; text-align: center; width: 1366px; background-position: initial initial; background-repeat: initial initial;">
		<nav class="navbar navbar-inverse" role="navigation">
		<ul class="nav nav-pills">
			<li class="active"><button type="button " class="btn btn-info navbar-btn">信息查看</button></li>
			<li><button type="button" class="btn btn-default navbar-btn" id="dish_finish">上菜呼叫</button></li>
		</ul>
		</nav>
	</div-->
    <div id="west" data-options="region:'west', split:true" style="width:100px;"></div>
    <div id="center" data-options="region:'center'" style="padding:5px;background:#eee;"></div>
<script>	
$(document).ready(function () {
	load_orders();
	$('#dish_finish').bind('click', function() {
		$.getJSON(
		"worker/cooker/CookerCallWaiter.php",
		function (data) {
			if (data['success']) {
				$.messager.show({
				title:'上菜呼叫',
				msg:'已经呼叫服务员过来取菜，本窗口将在5秒后自动关闭。',
				timeout:5000,
				showType:'slide'
				});
			}
		});
	});		
});
var orders = {};
function list_order() {
	$('#west').empty();
	var span = $('<span class="label label-info my-label"></span>').appendTo('#west');
	$(span).html('订单号：');
	for (i = 0; i < parseInt(orders['ordernum']); i++) {
		var button = $('<button type="button" class="btn btn-default navbar-btn" style="display:block;"></button>').appendTo('#west')
		var oid = orders['cols'][i]['oid'];
		$(button).html(oid);
		$(button).bind('click', function() {
			var oid = $(this).html();
			lookup_order(oid);
		});
	}
}
function load_orders() {
	$('#center').empty();	
	$.getJSON(
	"worker/admin/get_order.php",
	function (data) {
		orders = data;
		list_order();
	});	
}
function lookup_order(oid) {
	$('#center').empty();
	for (i=0; i < orders['ordernum']; i++) {
		if (orders['cols'][i]['oid'] == oid) {
			var div1 = $('<div ></div>').appendTo('#center');
			var span = $('<span class="label label-default my-label"></span>').appendTo(div1);
			$(span).html('订单号:');
			var span2 = $('<span class="label label-info my-label"></span>').appendTo(div1);
			$(span2).html(oid);
			
			var div2 = $('<div></div>').appendTo('#center');
			span3 = $(span).clone().appendTo(div2);
			$(span3).html("桌位:");
			span4 = $(span2).clone().appendTo(div2);
			$(span4).html(orders['cols'][i]['tname']);
			
			var div3 = $('<div></div>').appendTo('#center');
			span5 = $(span).clone().appendTo(div3);
			$(span5).html("时间日期:");
			span6 = $(span2).clone().appendTo(div3);
			$(span6).html(orders['cols'][i]['datetime']);
			
			var div4 = $('<div></div>').appendTo('#center');
			span7 = $(span).clone().appendTo(div4);
			$(span7).html("消费金额:");
			span8 = $(span2).clone().appendTo(div4);
			$(span8).html(orders['cols'][i]['totalprice']);
			
			var div5 = $('<div></div>').appendTo('#center');
			span9 = $(span).clone().appendTo(div5);
			$(span9).html("订单状态:");
			span10 = $(span2).clone().appendTo(div5);
			if (orders['cols'][i]['ostate'] == 0)
				state="未完成";
			else
				state="已完成";
			$(span10).html(state);
			var div6 = $('<div></div>').appendTo('#center');
			span11 = $(span).clone().appendTo(div6);
			$(span11).html('订单中的菜品:');
			var rnum = orders['cols'][i]['rnum'];
			rows = orders['cols'][i]['rows'];
			var div7 = $('<div></div>').appendTo('#center');
			for (j = 0; j < rnum; j++) {
				var span =  $('<span class="label label-info my-label"></span>').appendTo(div7);
				var s1 = $('<span></dpan>').appendTo(span);
				$(s1).html(rows[j]['fname']+" ");
				var s2 = $(s1).clone().appendTo(span);
				$(s2).html(rows[j]['fprice']+"￥ ");
				var s3 = $(s1).clone().appendTo(span);
				$(s3).html(rows[j]['fnum']+"份");
			}
			break;
		}
	}
}
	</script>
	</body>
</html>