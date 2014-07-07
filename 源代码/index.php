<?php
session_start();
//header("Location: index.html");
if (!isset($_GET['tableid']) and !isset($_SESSION['tableid'])) {
	echo '<script>location.href="tmp/set_table_id/"</script>';
	exit;
	// 互联网络
}
else {
	if (isset($_GET['tableid'])) {
		$_SESSION['tableid'] = $_GET['tableid'];
	}
}
?>
<html>
<head>
	<meta charset='gb2312'>
	<title>_(:3」∠)_</title>
	<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<link href="stylesheets/global_201405231304.css" rel="stylesheet" />
    <link href="stylesheets/restaurant_201405231304.css" rel="stylesheet" />
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="inline.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>	
</head>
<body>
<div id="table-id" style="display:none;"></div>
<div class="easyui-layout" style="width:100%;height:100%;">
	<div data-options="region:'north',split:true" style="height:35px;">
		<input id="ss" class="easyui-searchbox" style="width:300px"
			data-options="searcher:doSearch,prompt:'有什么吩咐吗？',menu:'#mm'"></input>
        
		<div id="mm" style="width:120px">
			<div data-options="name:'fname',iconCls:'icon-ok'">菜名</div>
			<div data-options="name:'fprice'">价格</div>
		</div>
		<a class="easyui-linkbutton" onclick="callwaiter()">呼叫服务员</a>
		<span id="login-reg">
		<a class="easyui-linkbutton" onclick="javascript:window.location.href='login.html'">登陆</a>
		<a class="easyui-linkbutton" onclick="javascript:window.location.href='reg.html'">注册</a>
		</span>
	</div>
    <div region="west" split="true" title="菜品导航" style="width:150px;">
        <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="javascript:void(0)" onclick="getdata(1)">今日推荐</a></li>
            <li><a href="javascript:void(0)" onclick="getdata(2)">本店特色</a></li>
            <li><a href="javascript:void(0)" onclick="getdata(3)">不好吃的</a></li>
            <li><a href="javascript:void(0)" onclick="getdata(4)">真的不好吃的</a></li>
        </ul>
    </div>
    <div id="content" region="center" title="菜品信息" style="padding:5px;">
		<div id="dishes"></div>
    </div>
</div>
<div id="user-btn" style="float:right;position:absolute;top:0px;left:380px;">
</div>
<div class="panel" style="float:right;position:absolute;top:0px;right:0px;" >
<div id="op" class="easyui-panel" title="空的订单" style="width:350px;height:300px;padding:10px;"
		data-options="collapsible:true" collapsed="true">
	<div id="op-content" style="height:210px;   overflow:auto;">
	<p style="font-size:14px" id="empty_cart">您还没有添加任何菜品。</p>
	</div>
	<div class="btn-group" style="margin-top:3px;">
		<button id="order-submit" type="button" class="btn btn-default">提交</button>
		<button id="order-refresh" "type="button" class="btn btn-default">刷新</button>
		<button id="order-pay" type="button" class="btn btn-default">结账</button>
	</div>

</div>
</div>
<script>
var login = false;
var username; 
$(document).ready(function()
{
	//默认展示“今日推荐”
	getdata(1);
	load_order();
	
    $.getJSON(
    "Action/IsLogin.php",
    function(data) {
		if (data['login'] == true) {
			login = true;
			username = data['username'];

			$('#login-reg').empty();
			var div = $('<div class="btn-group" style="float:left"></div>').appendTo('#user-btn');
			var button = $('<button id="table_1" class="btn dropdown-toggle btn-info" data-toggle="dropdown" type="button"></button>');
			$(button).appendTo(div);
			$(button).html(username);
			var span = $('<span class="caret"></span>');
			$(button).append(span);
			var ul = $('<ul class="dropdown-menu" role="menu"></ul>').appendTo(div);
			var li = $('<li></li>').appendTo(ul);
			var a = $('<a href="worker/customer/">会员中心</a>').appendTo(li);
			var li = $('<li></li>').appendTo(ul);
			var a = $('<a href="Action/LoginAction.php?action=logout1">注销</a>').appendTo(li);
			
		}
	})

	$('#order-submit').bind('click', function(){
		 topCenter('提交订单');
		 submit_order();
		 load_order();
    });

	$('#order-refresh').bind('click', function(){
		 load_order();
    });
	
	$('#order-pay').bind('click', function(){
		$.getJSON(
		"Action/MakePayment.php",
		{oid:order['oid']},
		function(data) {
			if (data["success"]) {
			topCenter("您消费的总金额为:"+order['totalprice']+"元，服务员正在过来结账，请稍等哦~");
			}
		});
    });
});

var dish_num = 0;
var order= {totalnum:0, foods:new Array()};

function submit_order() {
	 $.getJSON(
	 "Action/MakeOrderAction.php",
	 order,
	 function(data) {
		load_order();
	 });
}
function load_order() {
	$.getJSON(
	"Action/LoadOrder.php",
	function(data) {
		order = data;
		show_order();
	});	
}
function show_order() {
	var table;
	//if ($('#order-tb').length <= 0)
	$("#op-content").empty();
	table = $("<table id='order-tb'></table>").appendTo("#op-content");
	//table = $('#order-tb');
	for (var i = 0; i < order['diffnum']; i++) {
		if (parseInt(order['foods'][i]['fnum']) == 0)
			continue;
		var fid = order['foods'][i]['fid'];
		var nsp_id = "nsp_"+fid;
		tr = $("<tr></tr>").appendTo(table);
		$(tr).attr("id", "order_view_" + fid);
		
		td1 = $('<td style="width:120px"></td>').appendTo(tr);
		span1 = $("<span></span>");
		$(span1).html(order['foods'][i]['fname']);
		$(span1).appendTo(td1);
		td2 = $('<td style="width:50px"></td>').appendTo(tr);
		span2 = $('<span class="price symbol-rmb"></span>');
		$(span2).html(order['foods'][i]['fprice']);
		$(span2).appendTo(td2);
		
		td3 = $('<td style="width:50px"></td>').appendTo(tr);
		nspinner = $('<input style="width:40px"></input>');
		$(nspinner).attr('value', order['foods'][i]['fnum']);
		$(nspinner).attr("id", nsp_id);
		$(nspinner).appendTo(td3);
		$('#'+nsp_id).numberspinner({
			min: 0,
			max: 100,
			editable: false,
			onChange: function(newValue, oldValue) {/*
				var fid = $(this).parent().children().attr('id').slice(4);
				for (i in order['foods']) {
					if (order['foods'][i]['fid'] == fid) {//alert(i);
						if (newValue < order['foods'][i]['process']) {
							topCenter('已完成的菜品不能退订！');
							topCenter($(this).parent().children().numberspinner('setValue', oldValue));
						}
						order['foods'][i]['fnum'] = parseInt(newValue);
						
						var inc_price = parseInt(newValue - oldValue) *  parseFloat(order['foods'][i]['fprice']);
						order['totalprice'] = parseFloat(order['totalprice']) + inc_price;
						order['totalnum'] += parseInt(newValue - oldValue);
						show_order_title();
						if (parseInt(newValue) == 0) {
							$("#order_view_" + fid).remove();
							//order['foods'].splice(i,1);
						}
						break;
					}
				} */
			},
			onSpinUp: function() {
				var fid = $(this).parent().children().attr('id').slice(4);
				for (i in order['foods']) {
					if (order['foods'][i]['fid'] == fid) {//alert(i);
						newValue = $(this).parent().children().numberspinner('getValue')
						order['foods'][i]['fnum'] = parseInt(newValue);
						
						var inc_price = parseFloat(order['foods'][i]['fprice']);
						order['totalprice'] = parseFloat(order['totalprice']) + inc_price;
						order['totalnum'] += 1;
						show_order_title();
						break;
					}
				} 
			}, 
			onSpinDown: function() {
				var fid = $(this).parent().children().attr('id').slice(4);
				for (i in order['foods']) {
					if (order['foods'][i]['fid'] == fid) {//alert(i);
						newValue = $(this).parent().children().numberspinner('getValue')
						order['foods'][i]['fnum'] = parseInt(newValue);
						
						var inc_price = parseFloat(order['foods'][i]['fprice']);
						order['totalprice'] = parseFloat(order['totalprice']) - inc_price;
						order['totalnum'] -= 1;
						show_order_title();
						break;
					}
				} 
			} 
		});
		
		td4 = $('<td style="width:100px"></td>').appendTo(tr);
		span3 = $('<span></span>');
		var process = order['foods'][i]['process'];
		if (process == -1)
			$(span3).html('未提交');
		else if (process == 0)
			$(span3).html('已提交');
		else if (process >= 1)
			$(span3).html('已完成'+process+'份');
		$(span3).appendTo(td4);
	}
	show_order_title();			
}
function add_food(fid) {
	if($("#empty_cart").length > 0){
		$('#op-content').empty();
	}
	var order_view = "#order_view_" + fid;
	var nsp_id = "nsp_"+fid;
	if($(order_view).length > 0) {
		var pre_num;
		for (i in order['foods']) {
			if (order['foods'][i]['fid'] == fid) {
				var cur_num = parseInt(order['foods'][i]['fnum']); 
				order['foods'][i]['fnum'] = cur_num + 1;
				var value = order['foods'][i]['fnum'];
				$('#'+nsp_id).numberbox("setValue", parseInt(value));
				break;
			}
		} 
		show_order();	
	}
	else {
		$.getJSON(
		"worker/customer/get_foodinfo.php",
		{fid:fid}, 
		function (data){
			order['foods'].push({"fid":fid,"fnum":1, "fname":data['fname'],"fprice":data['fprice'],"fstate":0, "process":-1});
			var tnum = parseInt(order['totalnum']);
			order['totalnum'] = tnum + 1;
			order['totalprice'] = parseFloat(order['totalprice']) + parseFloat(data['fprice']);
			var dnum = parseInt(order['diffnum']);
			order['diffnum'] = dnum + 1;
			show_order();
		});
	}
	expand_panel(true);
}

function show_order_title() {
	$('#op').panel({'title':'查看订单' + ' ' + order['totalnum'] +'份 ￥'+order['totalprice']});
}
function expand_panel(option) {
	if (option)
		$('#op').panel('expand',false);
	else
		$('#op').panel('collapse',false);	
}

function create_add_btn(id, price) {
	div = $('<div class="rst-d-action r_d_a" style="float:right;"></div>');
	a = $('<a id="ab" class="rst-d-act-add add_btn" role="button" title="点击加入订单"></a>').appendTo(div);
	$(a).attr("onclick", "javascript:add_food("+id+")");
	span = $('<span class="price symbol-rmb"></span>').appendTo(a);
	$(span).html(price);
	return div;
}
function getdata(type){
    $.getJSON(
    "worker/customer/get_foods.php",
	{"type":type},
    function(data) {
		displayData(data);
	});
}
function displayData(data) {
	$('#dishes').empty();
	ul = $("<ul></ul>").appendTo("#dishes");
	$.each(data['rows'], function(k, v) {
		li = $("<li></li>").appendTo(ul);
		$(li).attr("class", "rst-dish-img-item");
		$(li).attr("id", "food_view_" + v['fid']);
		
		a = $("<a></a>").appendTo(li);
		$(a).attr("class", "rst-d-img-wrapper");
		
		img = $("<img style='width:232px;height:232px;'></img>").appendTo(a);
		$(img).attr("alt", v['fname']);
		$(img).attr("src", v['picurl']);
		
		div = $("<div></div>");
		$(div).html(v['fname']);
		$(div).appendTo(li);
		
		add_btn = create_add_btn(v['fid'], v['fprice']);
		$(add_btn).appendTo(li);
	});
}
function topCenter(message){
$.messager.show({
title:'提示消息',
msg:message,
showType:'slide',
style:{
right:'',
top:document.body.scrollTop+document.documentElement.scrollTop,
bottom:''
}
});
}
function callwaiter() {
	$.getJSON(
    "Action/CallWaiter.php",
    function(data) {
		if (data["success"]) {
			topCenter("已经将您的请求通知服务员，请稍等哦~");
		}
	});
}

function doSearch(value,name){
	$.getJSON(
    "worker/customer/SearchFood.php",
	{key:name, value:value},
    function(data) {
		if (data["success"]) {
			displayData(data);
		}
		else {
			alert(data['info']);
		}
	});
}
</script>
</body>
</html>