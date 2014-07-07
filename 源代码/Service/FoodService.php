<?php
include_once('../DAO/FoodDAO.php');

class FoodService{
	
	public function add_food($food) {
		$fdao = new FoodDAO();
		$add_rs = $fdao->add_food($food);
		return $add_rs;
	}
	public function edit_food($food) {
		$fdao = new FoodDAO();
		$edit_rs = $fdao->update_food($food);
		return $edit_rs;
	}
	public function delete_food($fid) {
		$fdao = new FoodDAO();
		$delete_rs = $fdao->delete_via_id($fid);
		return $delete_rs;
	}
}
?>