<?php
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['cooker'])){
    header("Location:../");
    exit();
}
echo '<div id="uname" style="display:none;">' . $_SESSION['cooker'] . '</div>';
?>
<!doctype html>
<html>
	<head>
		<meta charset='gb2312'>
		<title>后厨</title>
		<base href="../../" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
		<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
		<link rel="stylesheet" type="text/css" href="worker/cooker/cooker.css">
		<script type="text/javascript" src="easyui/jquery.min.js"></script>
		<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>	
	</head>
	<body>
    <nav class="navbar navbar-inverse" role="navigation">
	<div class="navbar-header">
    <a class="navbar-brand" href="#">首页</a>
	</div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="active"><a href="javascript:lookup_order();">信息查看</a></li>
      <li><a href="javascript:dish_finish_call()">上菜呼叫</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a id='user-btn' href="#" class="dropdown-toggle" data-toggle="dropdown">none</a>
        <ul class="dropdown-menu">
          <li><a href="Action/LoginAction.php?action=logout3">注销</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
	</nav>
	<div class="easyui-layout" style="display:block;min-height:550px">
		<!--nav class="navbar navbar-inverse" role="navigation">
		<ul class="nav nav-pills">
			<li class="active"><button type="button " class="btn btn-info navbar-btn">信息查看</button></li>
			<li><button type="button" class="btn btn-default navbar-btn" id="dish_finish">上菜呼叫</button></li>
		</ul>
		</nav-->
    <div id="west" data-options="region:'west', split:true" style="width:200px;">
	</div>
    <div id="center" data-options="region:'center'" style="padding:5px;background:#eee;">
	</div>
	</div>
<script>	
$(document).ready(function () {
	lookup_order();	
	var uname = $('#uname').html();
	$('#user-btn').html(uname+'<b class="caret"></b>');
});

function dish_finish_call () {
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
}
function lookup_order() {
	$('#west').empty();		
	$.getJSON(
	"worker/cooker/GetOrderList.php",
	function (data) {
		for (i = 0; i < parseInt(data['listnum']); i++) {
			var button = $('<button type="button" class="btn btn-default navbar-btn"></button>').appendTo('#west')
			$(button).html(data['lists'][i]['tname']);
			$(button).bind('click', function() {
				var oid = $(this).children().html();
				load_order(oid);
			});
			var span = $('<span style="display:none"></span>').appendTo(button);
			$(span).html(data['lists'][i]['oid']);
		}
	});	
}
var order = {};
var predata = [];
function load_order(oid) {
	$('#center').empty();	
	$.getJSON(
	"worker/cooker/LoadOrder.php",
	{oid:oid},
	function (data) {
		predata = data;
		order['oid'] = data['oid'];
		for (i = 0; i < parseInt(data['diffnum']); i++) {
			var div1 = $('<div class="req-panel"></div>').appendTo('#center');
			var __span = $('<span style="min-width:300px;display:inline-block"></span>').appendTo(div1);
			var span0 = $('<span style="display:none"></span>').appendTo(__span);
			var fid = data['foods'][i]['fid'];
			$(span0).html(data['foods'][i]['fid']);
			var span1 = $('<span class="label label-info my-label"></span>').appendTo(__span);
			$(span1).html(data['foods'][i]['fname']);
			var span2 = $('<span class="label label-default my-label"></span>').appendTo(__span);
			$(span2).html("数量:"+data['foods'][i]['fnum']);
			var span3 = $('<span class="label label-default my-label"></span>').appendTo(__span);
			$(span3).html("完成度:");
			var span4 = $('<span></span>').appendTo(span3);
			$(span4).html(data['foods'][i]['process']);
			
			var button = $('<button type="button" class="btn btn-default" style=""></button>').appendTo(div1);
			var span = $('<span class="glyphicon glyphicon-plus"></span>').appendTo(button);
			$(button).click(function (){
				var fid = $(this).parent().children().children().html();
				var proces, fnum;
				for (j = 0; j < parseInt(predata['diffnum']); j++) {
					if (fid == predata['foods'][j]['fid']) {
						process = parseInt(predata['foods'][j]['process']);
						fnum = parseInt(predata['foods'][j]['fnum']);
						break;
					}
				}
				if (process + 1 <= fnum) {
					order['fid'] = fid;
					order['process'] = process + 1;
					$.getJSON(
					"worker/cooker/ChangeFoodProcess.php",
					order,
					function (data){
						if (data['success']) {
							load_order(order['oid']);
						}
					});
				}
			});
			
			
			var button2 = $('<button type="button" class="btn btn-default" style=""></button>').appendTo(div1);
			var span = $('<span class="glyphicon glyphicon-minus"></span>').appendTo(button2);
			$(button2).click(function (){
				var fid = $(this).parent().children().children().html();
				var process, fnum;
				for (j = 0; j < parseInt(predata['diffnum']); j++) {
					if (fid == predata['foods'][j]['fid']) {
						process = parseInt(predata['foods'][j]['process']);
						fnum = parseInt(predata['foods'][j]['fnum']);
						break;
					}
				}
				if (process - 1 >= 0) {
					order['fid'] = fid;
					order['process'] = process - 1;
					$.getJSON(
					"worker/cooker/ChangeFoodProcess.php",
					order,
					function (data){
						if (data['success']) {
							load_order(order['oid']);
						}
					});
				}
			});
			
		}
	});	
}
	</script>
	</body>
</html>