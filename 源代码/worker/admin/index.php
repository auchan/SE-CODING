<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['admin'])){
    header("Location:/worker");
    exit();
}
echo '<div id="uname" style="display:none;">' . $_SESSION['admin'] . '</div>';
?>
<!doctype html>
<html>
<head>
	<meta charset='gb2312'>
	<title>admin</title>
	<base href="../../" />
	<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
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
          <li><a href="Action/LoginAction.php?action=logout4">注销</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
	</nav>
<div id="main" class="easyui-layout" style="width:100%;height:100%;">
    <div data-options="region:'west',split:true" style="width:150px;">
        <ul>
            <li><a href="/worker/admin/staff_manage.php" target="content" onclick="showcontent('staff_manage')">员工信息管理</a></li>
            <li><a href="/worker/admin/food_manage.php" target="content" onclick="showcontent('foods_manage')">菜品信息管理</a></li>
            <li><a href="/worker/admin/search_order.php" target="content" onclick="showcontent('order_query')">订单信息查询</a></li>
        </ul>
	</div>
    <div id="content-wrapper" data-options="region:'center',borde:'false'">
	<iframe id="content" name="content" src="/Action/admin/welcome.png" style="width:98%;height:99%;"></iframe>
	</div>
	<div data-options="region:'east',title:'East',split:true,closed:true" style="width:100px;"></div>
</div>

<script>
$(document).ready(function () {
	var uname = $('#uname').html();
	$('#user-btn').html(uname+'<b class="caret"></b>');
});
</script>
</body>
</html>