<?php
if($_POST){

	include('../Service/StaffManageService.php');

	extract($_POST);
	$uid = $_GET['uid'];
	
	$staff_detail = new Staff($name, $sex, $age, $phonenumber);
	$staff_detail->set_uid($uid);
	$user = new User($username, $password, $usertype);
	$user->set_uid($uid);
	$edits = New StaffManageService();
	$edit_rs = $edits->edit_staff($user, $staff_detail);
	if ($edit_rs == 1) {
		$rs = Array("success"=>true);
		echo json_encode($rs);
		exit;
	}
	else if ($edit_rs == 0) {
		//echo '错误：用户名 ',$username,' 已存在。<a href="javascript:history.back(-1);">返回</a>';
		$rs = Array("success"=>false);
		echo json_encode($rs);
		exit;
	}
	else {
		$rs = Array("success"=>false);
		echo json_encode($rs);
		exit;
	}
}
?>