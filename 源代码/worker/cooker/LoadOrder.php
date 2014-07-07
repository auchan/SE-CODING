<?php
	include_once(dirname(__FILE__) . '/../../DAO/UserDAO.php');
	session_start();

	extract($_GET);
	$totalnum = 0;
	$diffnum = 0;
	$load_rs['foods'] = array();

	$sql = "exec load_order_via_oid $oid";
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
		$fstate = odbc_result($rs, 5);
		$process = odbc_result($rs, 6);
		$tup = array('fid'=>$fid, 'fnum'=>$fnum, 'fname'=>$fname, 'fstate'=>$fstate, 'process'=>$process);
		$load_rs['foods'][] = $tup;
		$totalnum += intval($fnum);
		$diffnum++;
	}	
	
	$load_rs['oid'] = $oid;
	$load_rs['totalnum'] = $totalnum;
	$load_rs['diffnum'] = $diffnum;
	echo json_encode($load_rs);
?>