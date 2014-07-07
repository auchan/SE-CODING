<?php
//包含数据库连接文件
include_once('../conn.php');
require_once('../Bean/Customer.php');
class CustomerDAO 
{
	public function __construct() {
    }
	public function __destruct() {
	   //global $conn;
       //odbc_close($conn);
    }
	public function get_email($uid) {
		global $conn;
		//检测用户名及密码是否正确
		$email_rs = odbc_exec($conn, "select top 1 email from customer 
					where uid='$uid' ");
		if (!$email_rs)
		{
			return -1;
		}
		odbc_fetch_row($email_rs);
		$email = odbc_result($email_rs, "email");
		if ($email)
		{
			return $email;
		}
		return 0;
	}
	public function get_phonenumber($uid) {
		global $conn;
		//检测用户名及密码是否正确
		$pnumber_rs = odbc_exec($conn, "select top 1 phonenumber from customer 
					where uid='$uid' ");
		if (!$pnumber_rs)
		{
			return -1;
		}
		odbc_fetch_row($pnumber_rs);
		$phonenumber = odbc_result($pnumber_rs, "phonenumber");
		if ($phonenumber)
		{
			return $phonenumber;
		}
		return 0;
	}
	public function add_customer($customer) {
		global $conn;
		$uid = $customer->get_uid();
		$email = $customer->get_email();
		$phonenumber = $customer->get_phonenumber();
		$regdate = $customer->get_regdate();
		$sql = "insert into customer (uid, email, phonenumber, regdate)
				values($uid, '$email', '$phonenumber', $regdate)";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		return 1;
	}
	public function delete_customer($uid) {
		global $conn;
		$sql = "delete from customer where uid='$uid' ";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		return 1;
	}
}
?>