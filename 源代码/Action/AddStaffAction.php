<?php
if($_POST){

	include('../Service/RegService.php');

	extract($_POST);
	
	$staff_detail = new Staff($name, $sex, $age, $phonenumber);
	$user = new User($username, $password, $usertype);
	$regs = new RegService();
	$reg_rs = $regs->register_staff($user, $staff_detail);

	if ($reg_rs == 1) {
		//echo '<script>history.back(-1);</script>';
		$rs = Array("successMsg"=>"添加员工成功！");
		echo json_encode($rs);
		exit;
	}
	else if ($reg_rs == 0) {
		$rs = Array("errorMsg"=>"用户名已存在！");
		echo json_encode($rs);
		exit;
	}
	else {
		$rs = Array("errorMsg"=>"SQL Error!");
		echo json_encode($rs);
		exit;
	}
}
?>