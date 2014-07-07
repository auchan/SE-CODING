<?php
	include_once(dirname(__FILE__) . '/../../DAO/UserDAO.php');
	session_start();

	extract($_GET);

	$sql = "update food_in_order set process=$process 
			where order_id=$oid and food_id=$fid";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($error);
		exit;
	}
	$srs = array("success"=>true);
	echo json_encode($srs);
?>