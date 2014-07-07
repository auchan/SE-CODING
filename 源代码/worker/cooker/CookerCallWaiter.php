<?php
	include_once(dirname(__FILE__) . '/../../DAO/FoodDAO.php');
	
	date_default_timezone_set('PRC');
	$datetime = date("Y-m-d H:i:s");

	$sql = "insert into cooker_call values('$datetime', 0)";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$rs = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($rs);
		exit;
	}
	$rs = array("success"=>true, "info"=>"");
	echo json_encode($rs);
?>