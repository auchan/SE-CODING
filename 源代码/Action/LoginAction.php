<?php
	include('../Service/LoginService.php');
	
	$ls = new LoginService();
	
	//ע����¼
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
	
	//���ʺϷ��Լ��
	if(!($ls->valid_check())) {
		exit('�Ƿ�����!');
	}
	extract($_POST);
	// ��½
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
		echo '�û����ʹ��󣡵���˴� <a href="javascript:history.back(-1);">����</a> ����';
		exit;
	}
	exit('�û�����������󣡵���˴� <a href="javascript:history.back(-1);">����</a> ����');
?>