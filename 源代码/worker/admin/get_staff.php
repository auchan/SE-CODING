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
				$user[$j] = rtrim($user[$j]);		// ȥ���ұߵ����ÿհ׷�
				$t[$uhead[$j]] = $user[$j];
			}
		}
		else if ($shead[$i] == "name"){ 
			// ����MS SQL Server ��������gb2312�洢��
			// ��json_encode ֻ֧��UTF-8������Ҫ���б���ת��
			$elem  = iconv("gbk", "utf-8", $elem);
		}
		$elem  = rtrim($elem);		// ȥ���ұߵ����ÿհ׷�
		$t[$shead[$i]] = $elem;
		$i+=1;
	}
	$staffs["rows"][] = $t;

	$num += 1;
}
$staffs["total"] = $num;
echo json_encode($staffs);
?>
