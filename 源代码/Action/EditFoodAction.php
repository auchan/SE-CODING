<?php
if($_POST){

	include('../Service/FoodService.php');

	extract($_POST);
	$fid = $_GET['fid'];

	$food = new Food($fname, $fprice, $ftype, $picurl, $descrip);
	$food->set_id($fid);
	$foodser = New FoodService();
	$edit_rs = $foodser->edit_food($food);
	if ($edit_rs == 1) {
		$rs = Array("success"=>true);
		echo json_encode($rs);
		exit;
	}
	else if ($edit_rs == 0) {
		$rs = Array("success"=>false);
		echo json_encode($rs);
		exit;
	}
	else {
		$rs = Array("success"=>false);
		echo json_encode($rs);
		exit;
	}
}
?>