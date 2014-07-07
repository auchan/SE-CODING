<?php
include_once('../DAO/UserDAO.php');

class UserService{
	public function delete_user($uid) {
		$userdao = new UserDAO();
		$delete_rs = $userdao->delete_via_uid($uid);
		return $delete_rs;
	}
}
?>