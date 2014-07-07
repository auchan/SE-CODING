<?php
	include_once(dirname(__FILE__) . '/../../DAO/FoodDAO.php');

	session_start();
	$sql = "exec cooker_call_num";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$rs = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($rs);
		exit;
	}
	odbc_fetch_row($rs);
	$callnum = odbc_result($rs, 1);
	$rs = array("success"=>true, "callnum"=>$callnum);
	echo json_encode($rs);
?>