<?php
	include_once(dirname(__FILE__) . '/../../DAO/UserDAO.php');
	session_start();

	$sql = "select order_id, table_name from [order] as o, [table] as t 
			where order_state = 0 and o.table_id = t.table_id";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($error);
		exit;
	}	
	$listnum = 0;
	while (odbc_fetch_row($rs)) {
		$oid = odbc_result($rs, 1);
		$tname = odbc_result($rs, 2);
		$tname  = iconv("gbk", "utf-8", $tname);
		$tup = array('oid'=>$oid, 'tname'=>$tname);
		$load_rs['lists'][] = $tup;
		$listnum++;
	}	
	$load_rs['listnum'] = $listnum;
	echo json_encode($load_rs);
?>