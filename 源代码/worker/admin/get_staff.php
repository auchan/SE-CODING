<?php
include dirname(__FILE__) . "/../../DAO/StaffDAO.php";
include dirname(__FILE__) . "/../../DAO/UserDAO.php";

$shead = Array("uid", "name", "sex", "age", "phonenumber", "regdate");
$uhead = Array("uid", "username", "password", "usertype");

$sdao = New StaffDAO();
$datas = $sdao->get_all_staffs();
$userdao = New UserDAO();

$num = 0;
$staffs = Array();
$staffs["rows"] = Array();

foreach ($datas as $data) {
	$t = array();
	$i = 0;
	foreach ($data as $elem) {
		if ($shead[$i] == "uid") {
			$user = $userdao->get_user($elem);
			for ($j = 1; $j <=3; $j++) {
				$user[$j] = rtrim($user[$j]);		// 去除右边的无用空白符
				$t[$uhead[$j]] = $user[$j];
			}
		}
		else if ($shead[$i] == "name"){ 
			// 由于MS SQL Server 中文是以gb2312存储的
			// 而json_encode 只支持UTF-8，所以要进行编码转换
			$elem  = iconv("gbk", "utf-8", $elem);
		}
		$elem  = rtrim($elem);		// 去除右边的无用空白符
		$t[$shead[$i]] = $elem;
		$i+=1;
	}
	$staffs["rows"][] = $t;

	$num += 1;
}
$staffs["total"] = $num;
echo json_encode($staffs);
?>
