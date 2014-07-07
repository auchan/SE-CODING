<?php
include('../DAO/UserDAO.php');

class LoginService
{
	public function __construct() {
       session_start();
    }
	public function __destruct() {
   }
	public function logout() {
		if(isset($_GET['action'])){
			switch ($_GET['action']) {
				case "logout1":
					unset($_SESSION['customer']);
					return 1;
					break;
				case "logout2":
					unset($_SESSION['waiter']);
					return 2;
					break;
				case "logout3":
					unset($_SESSION['cooker']);
					return 3;
					break;
				case "logout4":
					unset($_SESSION['admin']);
					return 4;
					break;
				default:
					return false;
			}
			
			//unset($_SESSION['usertype']);
		}
		return false;
	}
	public function login($user) {
		$password = md5($user->get_password());
		$username = $user->get_username();
		//检测用户名及密码是否正确
		$userdao = new UserDAO();
		$pwd = $userdao->get_password($username);
		if ($pwd == -1)
		{
			return -1;
		}
		$usertype = $userdao->get_usertype($username);
		if ($usertype == -1)
		{
			return -1;
		}
		if (!is_numeric($pwd) and $pwd == $password)
		{
			if ($usertype == $user->get_type()) {
				//$_SESSION['username'] = $username;
				$_SESSION['usertype'] = $usertype;
				switch ($usertype) {
					case 1:
						$_SESSION['customer'] = $username;
						break;
					case 2:
						$_SESSION['waiter'] = $username;
						break;
					case 3:
						$_SESSION['cooker'] = $username;
						break;
					case 4:
						$_SESSION['admin'] = $username;
						break;
				}
				return 1;
			}
			else {
				return 2;
			}
		}
		return 0;
	}
	public function valid_check() {
		//return isset($_POST['submit']);
		return true;
	}
}
?>