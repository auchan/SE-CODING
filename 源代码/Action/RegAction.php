<?php
if($_POST){

	include('../Service/RegService.php');

	extract($_POST);
	
	$cust_detail = new Customer($email, $phonenumber);
	$user = new User($username, $password, 1);
	$regs = new RegService();
	$reg_rs = $regs->register_customer($user, $cust_detail);
	if ($reg_rs == 1) {
		echo '�û�ע��ɹ�������˴� <a href="../login.html">��¼</a>';
		exit;
	}
	else if ($reg_rs == 0) {
		echo '�����û��� ',$username,' �Ѵ��ڡ�<a href="javascript:history.back(-1);">����</a>';
		exit;
	}
	else {
		exit("Error in SQL");
	}
}
?>