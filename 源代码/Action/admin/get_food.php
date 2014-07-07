<?php
include_once dirname(__FILE__) . "/../../DAO/FoodDAO.php";

$fhead = Array("fid", "fname", "fprice", "ftype", "picurl", "descrip");

$fdao = New FoodDAO();
$datas = $fdao->get_all_foods();

$num = 0;
$foods = Array();
$foods["rows"] = Array();

foreach ($datas as $data) {
	$t = array();
	$i = 0;
	foreach ($data as $elem) {
		if ($fhead[$i] == "fname" || $fhead[$i] == "picurl" || $fhead[$i] == "descrip"){ 
			// 由于MS SQL Server 中文是以gb2312存储的
			// 而json_encode 只支持UTF-8，所以要进行编码转换
			$elem  = iconv("gbk", "utf-8", $elem);
		}
		$elem  = rtrim($elem);		// 去除右边的无用空白符
		$t[$fhead[$i]] = $elem;
		$i+=1;
	}
	$foods["rows"][] = $t;

	$num += 1;
}
$foods["total"] = $num;
echo json_encode($foods);
?>
