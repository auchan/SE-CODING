<?php
	include_once(dirname(__FILE__) . '/../DAO/FoodDAO.php');

	session_start();
	//header("Location: index.html");
	if (!isset($_SESSION['tableid'])) {
		// 
		$rs = array("success"=>false, "info"=>"need table id.");
		echo json_encode($rs);
		exit;
	}
	$tid = rtrim($_SESSION['tableid']);
	
	date_default_timezone_set('PRC');
	$datetime = date("Y-m-d H:i:s");

	$sql = "insert into customer_call values($tid, '$datetime', 0)";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$rs = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($rs);
		exit;
	}
	$rs = array("success"=>true, "info"=>"");
	echo json_encode($rs);
?>