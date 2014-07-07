<?php
	include_once(dirname(__FILE__) . '/../DAO/FoodDAO.php');
	
	extract($_GET);
	$sql = "update [table] set table_state = $tstate where table_id = $tid";
	$rs = odbc_exec($conn, $sql);
	$state_rs;
	if (!$rs) {
		// sql error
		$state_rs = array("success"=>false, "errorInfo"=>"SQL Error.");
	}
	else {
		$state_rs = array("success"=>true);
	}
	echo json_encode($state_rs);
?>