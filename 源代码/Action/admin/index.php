<html>
<head>
	<meta charset='gb2312'>
	<title>admin</title>
	<base href="../../" />
	<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
</head>
<body>
<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['username'])){
    header("Location:worker.html");
    exit();
}else if ($_SESSION['usertype'] != 4) {
	echo '没有访问权限！';
	exit();
}
?>

<div id="main" class="easyui-layout" style="width:100%;height:100%;">
    <div data-options="region:'north',title:'North Title',split:true" style="height:100px;">
	<?php
		echo '管理员:' . $_SESSION['username'];
		echo '<br /><a href="Action/LoginAction.php?action=logout">注销登录</a><br />';
	?>	
	</div>
    <!--div data-options="region:'south',title:'South Title',split:true" style="height:100px;"></div-->
    <div data-options="region:'west',title:'West',split:true" style="width:150px;">
	    <p style="padding:5px;margin:0;">操作目录</p>
        <ul>
            <li><a href="/Action/admin/staff_manage.php" target="content" onclick="showcontent('staff_manage')">员工信息管理</a></li>
            <li><a href="/Action/admin/food_manage.php" target="content" onclick="showcontent('foods_manage')">菜品信息管理</a></li>
            <li><a href="javascript:void(0)" onclick="showcontent('order_query')">订单信息查询</a></li>
        </ul>
	</div>
    <div id="content-wrapper" data-options="region:'center',borde:'false'">
	<iframe id="content" name="content" src="/Action/admin/welcome.png" style="width:98%;height:99%;"></iframe>
	</div>
	<div data-options="region:'east',title:'East',split:true,closed:true" style="width:100px;"></div>
</div>

<script>

    //   window.location.reload();   

function showcontent(filename){
	//$('#content').attr('src', '/role/admin/staff_manage.html');
	//window.location.reload();   
}
</script>
</body>
</html>