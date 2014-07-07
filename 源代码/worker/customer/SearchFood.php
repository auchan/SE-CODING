<?php
	include_once dirname(__FILE__) . "/../../DAO/FoodDAO.php";
	extract($_GET);
	
	$fhead = Array("fid", "fname", "fprice", "ftype", "picurl", "descrip");
	$num = 0;
	$foods = Array();
	$foods["rows"] = Array();
	
	if ($key == 'fname') {
		$value = iconv("utf-8", "gbk", rtrim($value));
		$sql = "select * from food where foodname like '%$value%'";
	}
	else if ($key == 'fprice') {
		if (is_numeric($value)) {
			$sql = "select * from food where foodprice=$value";
		}
		else if (substr($value,0,1) == '>') {
			$value = intval(substr($value,1));
			$sql = "select * from food where foodprice>=$value";
		}
		else if (substr($value,0,1) == '<') {
			$value = intval(substr($value,1));
			$sql = "select * from food where foodprice<=$value";
		}
		else {
			$error_rs = array("success"=>false, "info"=>"搜索条件不正确");
			echo json_encode($error_rs);
			exit;
		}
	}
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error_rs = array("success"=>false, "info"=>"SQL Error 1");
		echo json_encode($error_rs);
		exit;
	}
	while (odbc_fetch_row($rs)) {
		for ($i = 0; $i < 6; $i++) {
			$t[$fhead[$i]] = odbc_result($rs, $i+1);
			$t[$fhead[$i]] = iconv("gbk", "utf-8", $t[$fhead[$i]]);
		}
		$foods['rows'][] = $t;
		$num++;
	}
	$foods["total"] = $num;
	$foods["success"] = true;
	echo json_encode($foods);
?>
