<?php
	include_once(dirname(__FILE__) . '/../../DAO/FoodDAO.php');

	session_start();
	$sql = "exec read_cust_req";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error_rs = array("success"=>false, "info"=>"SQL Error 1");
		echo json_encode($error_rs);
		exit;
	}
	$tnum = 0;
	$load_rs["tables"] = array();
	while (odbc_fetch_row($rs)) {
		$tid[] = odbc_result($rs, 1);
		$datetimes[] = odbc_result($rs, 2);
		$callstate[] = odbc_result($rs, 3);
		$tnum++;
	}
	for ($i=0; $i < $tnum; $i++) {
		$tableid = $tid[$i];
		$rs2 = odbc_exec($conn, "select table_name from [table] where table_id = $tableid");
		if (!$rs2) {
			$error_rs = array("success"=>false, "info"=>"SQL Error 2");
			echo json_encode($error_rs);
			exit;
		}
		odbc_fetch_row($rs2);
		$tname = odbc_result($rs2, 1);
		$tname  = iconv("gbk", "utf-8", $tname);
		$tup = array("tid"=>$tableid, "tname"=>$tname, "datetime"=>$datetimes[$i], "callstate"=>$callstate[$i]);
		$load_rs["tables"][] = $tup;
	}
	$load_rs["success"] = true;
	$load_rs["tnum"] = $tnum;
	echo json_encode($load_rs);
?>