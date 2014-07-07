<?php
	include('../Service/LoginService.php');
	
	$ls = new LoginService();
	
	//注销登录
	$lout_rs = $ls->logout();
	if ($lout_rs) {
		if ($lout_rs == 1) {
			echo "<script>location.href='../index.php';</script>";
		}
		else {
			echo '<script>history.go(-1);</script>';
		}
		exit;
	}
	
	//访问合法性检测
	if(!($ls->valid_check())) {
		exit('非法访问!');
	}
	extract($_POST);
	// 登陆
	$user = new User($username, $password, $usertype);
	$login_rs = $ls->login($user);
	if ($login_rs == 1)
	{
		if ($usertype == 1) {
			echo "<script>location.href='../index.php';</script>";
		}
		if ($usertype == 2) {
			echo "<script>location.href='../worker/waiter/';</script>";
		}
		else if ($usertype == 3){
			echo "<script>location.href='../worker/cooker/';</script>";
		}
		else if ($usertype == 4) {
			echo "<script>location.href='../worker/admin/index.php';</script>";
		}
		exit;
	}
	else if ($login_rs == 2)
	{
		echo '用户类型错误！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
		exit;
	}
	exit('用户名或密码错误！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
?>