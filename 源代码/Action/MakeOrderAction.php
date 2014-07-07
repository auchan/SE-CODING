<?php
	include_once(dirname(__FILE__) . '/../DAO/FoodDAO.php');
	include_once(dirname(__FILE__) . '/../DAO/UserDAO.php');
	
	session_start();
	extract($_GET);
	
	function check_food($oid, $fid) {
		global $conn;
		$rs = odbc_exec($conn, "select food_num, food_state from food_in_order where order_id = $oid and food_id = $fid");
		if (!$rs)
			error_log($oid . 'x' . $fid . "\r\n", 3, "errors.log");
		odbc_fetch_row($rs);
		
		$fnum = odbc_result($rs, 'food_num');
		$fstate = odbc_result($rs, 'food_state');
		error_log($fstate . '::' . $fnum . "\r\n", 3, "errors.log");
		return array("num"=>$fnum, "state"=>$fstate);
	}
	
//	$result['oid'] = $oid;
//	echo json_encode($result);
	error_log("\r\n totalnum:" . $totalnum . "\r\n", 3, "errors.log");
	foreach($foods as $food) {
		$fid = $food['fid'];
		$fnum = $food['fnum'];
		error_log($fid . ':' . $fnum . "\r\n", 3, "errors.log");
		$food_state = check_food($oid, $fid);
		if ($food_state['num'] == "")	{
			// 原来的订单中不存在此菜品 
			error_log("新增菜品:" . $fid . ':' . $fnum . "\r\n", 3, "errors.log");
			$rs = odbc_exec($conn, "insert into food_in_order values($oid, $fid, $fnum, 0, 0)");
		}
		else if ($food_state['num'] != $fnum) {
			// 原来的订单中存在此菜品, 但是数量不一样
			error_log("修改菜品:" . $fid . ':' . $fnum . "\r\n", 3, "errors.log");
			$rs = odbc_exec($conn, "update food_in_order set food_num = $fnum where order_id = $oid and food_id = $fid");	
		}
	}
	$ex_rs = odbc_exec($conn, "exec del_zero_food");
	$mrs = array("success"=>true);
	echo json_encode($mrs);
?>