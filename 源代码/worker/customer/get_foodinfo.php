<?php

if (!isset($_GET['type'])) {
	//exit("{'errinfo':'���ʷ�ʽ����'}");
}
include_once dirname(__FILE__) . "/../../DAO/FoodDAO.php";

$fhead = Array("fid", "fname", "fprice", "ftype", "picurl", "descrip");

$fdao = New FoodDAO();
$data = $fdao->get_via_id($_GET['fid']);

$t = array();
$i = 0;
foreach ($data as $elem) {
	if ($fhead[$i] == "fname" || $fhead[$i] == "picurl" || $fhead[$i] == "descrip"){ 
		// ����MS SQL Server ��������gb2312�洢��
		// ��json_encode ֻ֧��UTF-8������Ҫ���б���ת��
		$elem  = iconv("gbk", "utf-8", $elem);
	}
	//if ($fhead[$i] == "fname" || $fhead[$i] == "fprice"  || $fhead[$i] == "picurl") {
	$elem  = rtrim($elem);		// ȥ���ұߵ����ÿհ׷�
	$t[$fhead[$i]] = $elem;
//	}
	$i+=1;
}
$food = $t;

echo json_encode($food);
?>
