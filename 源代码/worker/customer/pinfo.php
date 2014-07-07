<?php
	include_once dirname(__FILE__) . "/../../DAO/UserDAO.php";
	session_start();
	extract($_GET);
	if (!isset($_SESSION['customer'])){
		$error_rs = array("success"=>false, "info"=>"not login");
		echo json_encode($error_rs);
		exit;
	}
	$username = $_SESSION['customer'];
	$udao = new UserDAO();
	$uid = $udao->get_uid($username);
	
	$sql = "select * from customer where uid=$uid";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error_rs = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($error_rs);
		exit;
	}
	odbc_fetch_row($rs);
	$email = odbc_result($rs, 2);
	$phonenumber = odbc_result($rs, 3);
	$srs = array("success"=>true, "email"=>$email, "phonenumber"=>$phonenumber);
	echo json_encode($srs);
?>