<?php

class Customer
{	
	public function __construct($email='', $pn='', $uid='', $regdate='') {
		$this->uid = $uid;
		$this->email = $email;
		$this->phonenumber = $pn;
		$this->regdate = $regdate;
    }
	public function get_uid()
	{
		return $this->uid;
	}
	public function set_uid($uid)
	{
		$this->uid = $uid;
	}
	
	public function get_email()
	{
		return $this->email;
	}
	public function set_email($email)
	{
		$this->email = $email;
	}
	
	public function get_phonenumber()
	{
		return $this->phonenumber;
	}
	public function set_phonenumber($pn)
	{
		$this->phonenumber = $pn;
	}
	
	public function get_regdate()
	{
		return $this->regdate;
	}
	public function set_regdate($regdate)
	{
		$this->regdate = $regdate;
	}	

	private $uid;
	private $email;
	private $phonenumer;
	private $regdate;
}
?>