<?php
	include_once(dirname(__FILE__) . '/../DAO/FoodDAO.php');
	include_once(dirname(__FILE__) . '/../DAO/UserDAO.php');
	
	//session_start();
	$order_num = 0;
	$sql = "select order_id, datetime, table_num from [order] where order_state = 0";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		error_log("CookAction: SQL Error 1\r\n", 3, "errors.log");
	}
	while (odbc_fetch_row($rs)) {
		$oid[] = odbc_result($rs, 1);
		$datetime[] = odbc_result($rs, 2);
		$tablenum[] = odbc_result($rs, 3);
		$order_num++;
	}
	$order_rs = array("order_num"=>$order_num);
	$order_rs["orders"] = array();
	for ($i = 0; $i < $order_num; $i++) {
		$order_tup = array("oid"=>$oid[$i], "datetime"=>$datetime[$i], "tablenum"=>$tablenum[$i]);
	
		$totalnum = 0;
		$order_tup["foods"] = array();
		$sql = "exec order_look_food $oid[$i]";
		$rs = odbc_exec($conn, $sql);
		if (!$rs) {
			error_log("CookAction: SQL Error 2\r\n", 3, "errors.log");
		}
		while (odbc_fetch_row($rs)) {
			$fname = odbc_result($rs, 1);
			$fnum = odbc_result($rs, 2);
			$totalnum += $fnum;
			$fname  = iconv("gbk", "utf-8", $fname);
			$tup = array("fname"=>$fname, "fnum"=>$fnum);
			$order_tup["foods"][] = $tup;
		}
		$order_tup["totalnum"] = $totalnum;
		$order_rs["orders"][] = $order_tup;
	}
	echo json_encode($order_rs);
?>