<?php
include_once('../DAO/StaffDAO.php');
include_once('../DAO/UserDAO.php');

class StaffManageService 
{
	public function add_staff($uid, $staff) {
		$staffdao = new StaffDAO();
		$regdate = time();
		$staff->set_uid($uid);
		$staff->set_regdate($regdate);
		$add_rs = $staffdao->add_staff($staff);
		return $add_rs;
	}
	public function edit_staff($user, $staff) {
		$staffdao = new StaffDAO();
		$userdao = new UserDAO();
		$pwd = $user->get_password();
		if (!(strlen($pwd) == 32)) {
			$user->set_password(md5($pwd));
		}

		$userdao->update_user($user);
		$add_rs = $staffdao->update_staff($staff);
		
		return $add_rs;
	}
}
?>