<?php
if($_POST){

	include('../Service/RegService.php');

	extract($_POST);
	
	$cust_detail = new Customer($email, $phonenumber);
	$user = new User($username, $password, 1);
	$regs = new RegService();
	$reg_rs = $regs->register_customer($user, $cust_detail);
	if ($reg_rs == 1) {
		echo '用户注册成功！点击此处 <a href="../login.html">登录</a>';
		exit;
	}
	else if ($reg_rs == 0) {
		echo '错误：用户名 ',$username,' 已存在。<a href="javascript:history.back(-1);">返回</a>';
		exit;
	}
	else {
		exit("Error in SQL");
	}
}
?>