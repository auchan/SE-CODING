<?php

if (!isset($_GET['type'])) {
	//exit("{'errinfo':'访问方式错误'}");
}
include_once dirname(__FILE__) . "/../../DAO/FoodDAO.php";

$fhead = Array("fid", "fname", "fprice", "ftype", "picurl", "descrip");

$fdao = New FoodDAO();
$data = $fdao->get_via_id($_GET['fid']);

$t = array();
$i = 0;
foreach ($data as $elem) {
	if ($fhead[$i] == "fname" || $fhead[$i] == "picurl" || $fhead[$i] == "descrip"){ 
		// 由于MS SQL Server 中文是以gb2312存储的
		// 而json_encode 只支持UTF-8，所以要进行编码转换
		$elem  = iconv("gbk", "utf-8", $elem);
	}
	//if ($fhead[$i] == "fname" || $fhead[$i] == "fprice"  || $fhead[$i] == "picurl") {
	$elem  = rtrim($elem);		// 去除右边的无用空白符
	$t[$fhead[$i]] = $elem;
//	}
	$i+=1;
}
$food = $t;

echo json_encode($food);
?>
