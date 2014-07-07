<?php
class Food
{
	public function __construct($name, $price, $type, $picurl, $descrip) {
		$this->name = $name;
		$this->price = $price;
		$this->type = $type;
		$this->picurl = $picurl;
		$this->descrip = $descrip;
	}
	public function get_id()
	{
		return $this->id;
	}
	public function set_id($id)
	{
		$this->id = $id;
	}
	
	public function get_name()
	{
		return $this->name;
	}
	public function set_name($name)
	{
		$this->name = $name;
	}
	
	public function get_price()
	{
		return $this->price;
	}
	public function set_price($price)
	{
		$this->price = $price;
	}
	
	public function get_description()
	{
		return $this->descrip;
	}
	public function set_description($descrip)
	{
		$this->descrip = $descrip;
	}
	
	public function get_type()
	{
		return $this->type;
	}
	public function set_type($type)
	{
		$this->type = $type;
	}	
	
	public function get_picurl()
	{
		return $this->picurl;
	}
	public function set_picurl($url)
	{
		$this->picurl = $url;
	}
	private $id;
	private $name;
	private $price;
	private $descrip;
	private $type;
	private $picurl;
}
?>