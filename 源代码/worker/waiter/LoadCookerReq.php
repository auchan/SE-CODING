<?php
	include_once(dirname(__FILE__) . '/../../DAO/FoodDAO.php');

	session_start();
	$sql = "select ccid, datetime from cooker_call where call_state = 0";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error_rs = array("success"=>false, "info"=>"SQL Error 1");
		echo json_encode($error_rs);
		exit;
	}
	$num = 0;
	while (odbc_fetch_row($rs)) {
		$ccid = odbc_result($rs, 1);
		$datetime = odbc_result($rs, 2);
		$tup = array("ccid"=>$ccid, "datetime"=>$datetime);
		$load_rs["rows"][] = $tup;
		$num++;
	}
	$load_rs["num"] = $num;
	$load_rs["success"] = true;
	echo json_encode($load_rs);
?>