<?php
class Order
{
	public function get_id()
	{
		return $this->order_id;
	}
	public function set_id($id)
	{
		$this->order_id = $id;
	}
	
	public function get_foods()
	{
		return $this->foods;
	}
	public function set_foods($foods)
	{
		$this->foods = $foods;
	}
	
	public function get_food_qty()
	{
		return $this->food_qty;
	}
	public function set_food_qty($food_qty)
	{
		$this->food_qty = $food_qty;
	}
	private $order_id;
	private $foods;
	private $food_qty;
}
	
?>