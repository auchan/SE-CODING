<?php
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['waiter'])){
    header("Location:../");
    exit();
}
echo '<div id="uname" style="display:none;">' . $_SESSION['waiter'] . '</div>';
?>
<!doctype html>
<html>
	<head>
		<meta charset='gb2312'>
		<title>前台</title>
		<base href="../../" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
		<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
		<link rel="stylesheet" type="text/css" href="worker/waiter/waiter.css">
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
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a id='user-btn' href="#" class="dropdown-toggle" data-toggle="dropdown">none</a>
        <ul class="dropdown-menu">
          <li><a href="Action/LoginAction.php?action=logout2">注销</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
	</nav>
	<div class="easyui-layout" style="display:block;min-height:550px">
    <div data-options="region:'west',split:true" style="width:160px;">
	<ul class="nav nav-pills nav-stacked">
	<li class="active"><a href="javascript:lookup_table();">桌位查询</a></li>
	<li><a href="javascript:load_cust_req();"><span id='cust-req-num' class="badge pull-right"></span>服务请求</a></li>
	<li><a href="javascript:load_cooker_req()"><span id='cooker-req-num' class="badge pull-right"></span>上菜请求</a></li>
	</ul>
	</div>
    <div id="center" data-options="region:'center'" style="padding:5px;background:#eee;">
	</div>
	</div>
	<script>
	$(document).ready(function()
	{
		var uname = $('#uname').html();
		$('#user-btn').html(uname+'<b class="caret"></b>');
		setTimeout(check_cust_req, 1000); 
		setTimeout(check_cooker_req, 1000);
		lookup_table()
	});
	function lookup_table() {
		$('#center').empty();
		var li1 = $('.nav').children();
		$(li1).attr("class", "active");
		var li2 = $(li1).next();
		$(li2).attr("class", "");
		var li3 = $(li2).next();
		$(li3).attr("class", "");		
		$.getJSON(
		"Action/TableAction.php",
		function (data) {
			for (i = 0; i < parseInt(data['table_num']); i++) {
			var tid = data['tables'][i]['tid'];
			var state = parseInt(data['tables'][i]['tstate']);
			var state_words = ['空闲中', '使用中', '不可用'];
			var state_styles = ['btn-success', 'btn-warning', 'btn-danger'];
			
			var div1 = $('<div class="table-panel"></div>').appendTo('#center');
			var span0 = $('<span style="display:none;"></span>').appendTo(div1);
			$(span0).html(state);
			var div2 = $('<div style="height:160px;"></div>').appendTo(div1);
			var span1 = $('<span class="badge" ></span>').appendTo(div2);
			$(span1).html(data['tables'][i]['tname']);
			var div3 = $('<div class="btn-group"></div>').appendTo(div1);
			var button = $('<button type="button" data-toggle="dropdown"></button>').appendTo(div3);
			$(button).attr('class', 'btn dropdown-toggle ' + state_styles[state]);
			$(button).attr('id', 'table_' + tid);
			$(button).html(state_words[state]);
			var span2 = $('<span class="caret"></span>').appendTo(button);
			var ul = $('<ul class="dropdown-menu" role="menu"></ul>').appendTo(div3);
			var li1 = $('<li></li>').appendTo(ul);
			var a1 = $('<a href="javascript:changetablestate(' + tid + ', 0)">空闲中<li>').appendTo(li1);
			var li2 = $('<li></li>').appendTo(ul);
			var a2 = $('<a href="javascript:changetablestate(' + tid + ', 1)">使用中<li>').appendTo(li2);
			var li3 = $('<li></li>').appendTo(ul);
			var a3 = $('<a href="javascript:changetablestate(' + tid + ', 2)">不可用<li>').appendTo(li3);
			}
		});	
	}
	function check_cust_req() {
		$.getJSON(
		"worker/waiter/CheckCustomerCallNum.php",
		function (data) {
			if (data['success']) {
				var num = parseInt(data['callnum']);
				if (num == 0)
					num = "";
				$('#cust-req-num').html(num);
			}
		});
		
		setTimeout(check_cust_req, 1000);
	}
	function check_cooker_req() {
		$.getJSON(
		"worker/waiter/CheckCookerCallNum.php",
		function (data) {
			if (data['success']) {
				var num = parseInt(data['callnum']);
				if (num == 0)
					num = "";
				$('#cooker-req-num').html(num);
			}
		});
		
		setTimeout(check_cooker_req, 1000);
	}
	function load_cust_req() {
		$('#center').empty();
		var li1 = $('.nav').children();
		$(li1).attr("class", "");
		var li2 = $(li1).next();
		$(li2).attr("class", "active");
		var li3 = $(li2).next();
		$(li3).attr("class", "");
		$.getJSON(
		"worker/waiter/LoadCustomerReq.php",
		function (data) {
			if (data['success']) {
				for (i = 0; i < parseInt(data['tnum']); i++) {
					var div1 = $('<div class="req-panel"></div>').appendTo('#center');
					var span0 = $('<span style="display:none"></span>').appendTo(div1);
					$(span0).html(data['tables'][i]['tid']);
					var span1 = $('<span class="label label-info my-label"></span>').appendTo(div1);
					$(span1).html(data['tables'][i]['tname']);
					var span2 = $('<span class="label label-default my-label"></span>').appendTo(div1);
					$(span2).html(data['tables'][i]['datetime']);
					if (data['tables'][i]['callstate'] == 2) {
						var span_ex = $('<span class="label label-default my-label"></span>').appendTo(div1);
						$(span_ex ).html('结账');
					}
					var button = $('<button type="button" class="btn btn-default" style="float:right;"></button>').appendTo(div1);
					$(button).click(function (){
						var par = $(this).parent();
						var tableid = $(par).children().html();
						$.getJSON(
						"worker/waiter/ProcessReq.php",
						{tid:tableid},
						function (data) {
							if (data['success']) {
								$(par).remove();
							}
						});
					});
					var span3 = $('<span class="glyphicon glyphicon-remove"></span>').appendTo(button);
				}
			}
		});
	}
	function load_cooker_req() {
		$('#center').empty();
		var li1 = $('.nav').children();
		$(li1).attr("class", "");
		var li2 = $(li1).next();
		$(li2).attr("class", "");
		var li3 = $(li2).next();
		$(li3).attr("class", "active");
		$.getJSON(
		"worker/waiter/LoadCookerReq.php",
		function (data) {
			if (data['success']) {
				for (i = 0; i < parseInt(data['num']); i++) {
					var div1 = $('<div class="req-panel"></div>').appendTo('#center');
					var span0 = $('<span style="display:none"></span>').appendTo(div1);
					$(span0).html(data['rows'][i]['ccid']);
					var span2 = $('<span class="label label-default my-label"></span>').appendTo(div1);
					var dt = data['rows'][i]['datetime'];
					$(span2).html(dt);
					var button = $('<button type="button" class="btn btn-default" style="float:right;"></button>').appendTo(div1);
					$(button).click(function (){
						var par = $(this).parent();
						var ccid = $(par).children().html();
						$.getJSON(
						"worker/waiter/ProcessCookerReq.php",
						{ccid:ccid},
						function (data) {
							if (data['success']) {
								$(par).remove();
							}
						});
					});
					var span3 = $('<span class="glyphicon glyphicon-remove"></span>').appendTo(button);
				}
			}
		});
	}
	function changetablestate(tid, state) {
		var id_sel = '#table_'+tid;
		$.getJSON(
		"Action/EditTableStateAction.php",
		{tid:tid, tstate:state},
		function (data) {
			//alert(data);
		});
		// switch可以用上面的方法替代
		switch (state) {
			case 0:
				$(id_sel).attr('class', 'btn btn-success dropdown-toggle');
				$(id_sel).html('空闲中 <span class="caret"></span>');
				break;
			case 1:
				$(id_sel).attr('class', 'btn btn-warning dropdown-toggle');
				$(id_sel).html('使用中 <span class="caret"></span>');
				break;
			case 2:
				$(id_sel).attr('class', 'btn btn-danger dropdown-toggle');
				$(id_sel).html('不可用 <span class="caret"></span>');
				break;
			default:
				break;
		}
	}
	</script>
	</body>
</html>