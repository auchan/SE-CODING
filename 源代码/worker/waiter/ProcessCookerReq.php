<?php
	include_once(dirname(__FILE__) . '/../../DAO/FoodDAO.php');

	session_start();
	extract($_GET);
	$sql = "update cooker_call set call_state = 1 where call_state = 0 and ccid = $ccid";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error_rs = array("success"=>false, "info"=>"SQL Error 1");
		echo json_encode($error_rs);
		exit;
	}
	$success_rs = array("success"=>true);
	echo json_encode($success_rs);
?>