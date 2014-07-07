<?php
include_once('../DAO/UserDAO.php');
include_once('CustomerService.php');
include_once('StaffManageService.php');

class RegService
{
	public function __construct() {
		$this->userdao = new UserDAO();
    }
	public function isuname_exist($username) {
		$userdao = $this->userdao;
		$rs = $userdao->get_username($username);
		if (is_numeric($rs))
		{
			return $rs;
		}
		return 1;
	}
	public function register($user) {
		$username = $user->get_username();
		$this->username = $username;	// 保存username，用于回滚操作
		$uname_rs = $this->isuname_exist($username);
		if ($uname_rs == 1) {		// 用户名存在
			return 0;
		}
		else if ($uname_rs == -1) {
			return -1;				// SQL出错
		}
		$password = $user->get_password();
		$user->set_password(md5($password));
		$userdao = $this->userdao;
		if (!($userdao->add_user($user))) {
			return -1;
		}

		$uid = $userdao->get_uid($username);
		return $uid;
	}
	public function register_customer($user, $cust_info) {
		$uid = $this->register($user);
		if ($uid == 0 or $uid == -1) {
			return $uid;
		}
		$cust_service = new CustomerService();
		$cust_rs = $cust_service->add_customer($uid, $cust_info);
		if (!$cust_rs)
		{
			$this->rollback();
			return -2;
		}
		return 1;
	}
	public function register_staff($user, $staff_info) {
		$uid = $this->register($user);
		if ($uid == 0 or $uid == -1) {
			return $uid;
		}
		$staff_service = new StaffManageService();
		$staff_rs = $staff_service->add_staff($uid, $staff_info);
		if (!$staff_rs)
		{
			$this->rollback();
			return -2;
		}
		return 1;
	}
	public function rollback() {
		$userdao = $this->userdao;
		$userdao->delete_user($this->username);
	}
	private $username;
	private $userdao;
}
?>