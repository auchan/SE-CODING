<?php
	include_once dirname(__FILE__) . "/../../DAO/UserDAO.php";
	session_start();
	extract($_GET);
	if (!isset($_SESSION['customer'])){
		exit;
	}
	$username = $_SESSION['customer'];
	$udao = new UserDAO();
	$uid = $udao->get_uid($username);
	
	$sql = "exec cust_look_order $uid";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		$error_rs = array("success"=>false, "info"=>"SQL Error");
		echo json_encode($error_rs);
		exit;
	}
	$poid = -1;
	$num = 0;
	$rnum = 0;
	while (odbc_fetch_row($rs)) {
		$rnum++;
		$oid = odbc_result($rs, 1);
		$tname = odbc_result($rs, 2);
		$tname  = iconv("gbk", "utf-8", $tname);
		$datetime = odbc_result($rs, 3);
		$fname = odbc_result($rs, 4);
		$fname  = iconv("gbk", "utf-8", $fname);
		$fprice = odbc_result($rs, 5);
		$fnum = odbc_result($rs, 6);
		$totalprice = odbc_result($rs, 7);
		$ostate = odbc_result($rs, 8);
		$tup = array("fname"=>$fname, "fprice"=>$fprice, "fnum"=>$fnum);
		if ($poid == -1 or ($poid != -1 and $poid != $oid)) {
			$t[] = array('oid'=>$oid, 'tname'=>$tname, 'totalprice'=>$totalprice, 'datetime'=>$datetime, 'ostate'=>$ostate);
			$t[$num]['rows'][] = $tup;
			if ($poid != -1) {
				$t[$num-1]['rnum'] = $rnum-1;
				$rnum = 1;
			}
			$num++;
		}
		else {
			$t[$num-1]['rows'][] = $tup;
		}
		$poid = $oid;
	}
	$t[$num-1]['rnum'] = $rnum;
	$ors['cols'] = $t;
	$ors['ordernum'] = $num;
	$ors["success"] = true;
	echo json_encode($ors);
?>
