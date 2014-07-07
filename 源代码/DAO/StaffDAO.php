<?php
//包含数据库连接文件
include_once(dirname(__FILE__) . '/../conn.php');
require_once(dirname(__FILE__) . '/../Bean/Staff.php');
class StaffDAO 
{
	public function __construct() {
    }
	public function __destruct() {
	   //global $conn;
       //odbc_close($conn);
    }
	public function add_staff($staff) {
		global $conn;
		$uid = $staff->get_uid();
		$name = $staff->get_name();
		$sex = $staff->get_sex();
		$age = $staff->get_age();
		$phonenumber = $staff->get_phonenumber();
		$regdate = $staff->get_regdate();
		$sql = "insert into staff (uid, name, sex, age, phonenumber, regdate)
				values($uid, '$name', $sex, $age, '$phonenumber', $regdate)";

		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		return 1;
	}
	public function get_all_staffs() {
		global $conn;
		$sql = "select * from staff ";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		$staffs = array();
		$num = 0;
		while (odbc_fetch_row($rs)) {
			$staff = array();
			$colnum = 6;
			for ($i = 1; $i <= $colnum; $i++){
				$elem = odbc_result($rs, $i);
				$staff[$i-1] = $elem;
			}
			$staffs[$num] = $staff;
			$num += 1;
		}
		return $staffs;
	}
	public function update_staff($staff) {
		global $conn;
		$uid = $staff->get_uid();
		$name = $staff->get_name();
		$sex = $staff->get_sex();
		$age = $staff->get_age();
		$phonenumber = $staff->get_phonenumber();
		$sql = "update staff set name='$name', sex=$sex, age=$age, phonenumber='$phonenumber'
				where uid = $uid";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		return 1;
	}
}
?>