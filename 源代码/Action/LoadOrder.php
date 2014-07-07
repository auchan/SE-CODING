<?php
	include_once(dirname(__FILE__) . '/../DAO/UserDAO.php');
	session_start();
	$tid = $_SESSION['tableid'];
	$uid = 0;
	if (isset($_SESSION['customer'])){
		$username = $_SESSION['customer'];
		$udao = new UserDAO();
		$uid = $udao->get_uid($username);
	}
	extract($_GET);
	$totalnum = 0;
	$totalprice = 0;
	$diffnum = 0;
	$load_rs['foods'] = array();
	if ($uid != 0) {
		odbc_exec($conn, "update [order] set owner_id=$uid where order_state = 0 and table_id = $tid");
	}
	$sql = "select order_id from [order] where order_state = 0 and table_id = $tid";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($error);
		exit;
	}	
	if (!odbc_fetch_row($rs)) {
		date_default_timezone_set('PRC');
		$datetime = date("Y-m-d H:i:s");
		$rs = odbc_exec($conn, "insert into [order] values('$datetime', 0, 0, $uid, $tid)");
		$sql = "select order_id from [order] where owner_id = $uid and order_state = 0 and table_id = $tid";
		$rs = odbc_exec($conn, $sql);
		odbc_fetch_row($rs);
		$oid = odbc_result($rs, 1);
	}
	else {
		$oid = odbc_result($rs, 1);
		$sql = "exec load_order $tid";
		$rs = odbc_exec($conn, $sql);
		if (!$rs) {
			$error = array("success"=>false, "info"=>"SQL Error");
			echo json_encode($error);
			exit;
		}
		while (odbc_fetch_row($rs)) {
			$oid = odbc_result($rs, 1);
			$fid = odbc_result($rs, 2);
			$fnum = odbc_result($rs, 3);
			$fname = odbc_result($rs, 4);
			$fname  = iconv("gbk", "utf-8", $fname);
			$fprice = odbc_result($rs, 5);
			$fstate = odbc_result($rs, 6);
			$process = odbc_result($rs, 7);
			$tup=array('fid'=>$fid, 'fnum'=>$fnum, 'fname'=>$fname, 'fprice'=>$fprice, 'fstate'=>$fstate, 'process'=>$process);
			$load_rs['foods'][] = $tup;
			$totalnum += intval($fnum);
			$totalprice += floatval($fprice)*intval($fnum);
			$diffnum++;
		}	
	}
	$load_rs['oid'] = $oid;
	$load_rs['totalnum'] = $totalnum;
	$load_rs['totalprice'] = $totalprice;
	$load_rs['diffnum'] = $diffnum;
	echo json_encode($load_rs);
?>