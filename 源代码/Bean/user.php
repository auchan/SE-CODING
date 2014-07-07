<?php
class User
{	
	public function __construct($username='', $password='', $usertype='', $uid='') {
		$this->uid = $uid;
		$this->username = $username;
		$this->password = $password;
		$this->type = $usertype;
    }
	public function get_uid()
	{
		return $this->uid;
	}
	public function set_uid($uid)
	{
		$this->uid = $uid;
	}
	
	public function get_username()
	{
		return $this->username;
	}
	public function set_username($username)
	{
		$this->username = $username;
	}
	
	public function get_password()
	{
		return $this->password;
	}
	public function set_password($password)
	{
		$this->password = $password;
	}
	
	public function get_type()
	{
		return $this->type;
	}
	public function set_type($type)
	{
		$this->type = $type;
	}	

	private $uid;
	private $username;
	private $password;
	private $type;
}
?>