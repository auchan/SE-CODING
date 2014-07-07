<?php

class Staff
{	
	public function __construct($name, $sex, $age, $pn='', $regdate='') {
		$this->name = $name;
		$this->sex = $sex;
		$this->age = $age;
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
	
	public function get_name()
	{
		return $this->name;
	}
	public function set_name($name)
	{
		$this->name = $name;
	}
	
	public function get_age()
	{
		return $this->age;
	}
	public function set_age($age)
	{
		$this->age = $age;
	}
	
	public function get_sex()
	{
		return $this->sex;
	}
	public function set_sex($sex)
	{
		$this->sex = $sex;
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
	private $name;
	private $sex;
	private $age;
	private $phonenumer;
	private $regdate;
}
?>