<?php
	include_once(dirname(__FILE__) . '/../DAO/FoodDAO.php');
	
	$sql = "select * from [table]";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		// sql error
	}
	$table_rs;
	$table_rs["tables"] = array();
	$table_num = 0;
	while (odbc_fetch_row($rs)) {
		$table_num += 1;
		$tid = odbc_result($rs, 1);
		$tname = odbc_result($rs, 2);
		$tname  = iconv("gbk", "utf-8", $tname);
		$tstate = odbc_result($rs, 3);
		$tup = array("tid"=>$tid, "tname"=>$tname, "tstate"=>$tstate);
		$table_rs["tables"][] = $tup;
	}
	$table_rs["table_num"] = $table_num;
	echo json_encode($table_rs);
?>