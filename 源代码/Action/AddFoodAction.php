<?php
if($_POST){

	include('../Service/FoodService.php');

	extract($_POST);
	
	$food = new Food($fname, $fprice, $ftype, $picurl, $descrip);
	$foodser = new FoodService();
	$add_rs = $foodser->add_food($food);
	$add_rs = 1;
	if ($add_rs == 1) {
		$rs = Array("successMsg"=>"添加菜品成功！");
		echo json_encode($rs);
		exit;
	}
	else if ($add_rs == 0) {
		$rs = Array("errorMsg"=>"SQL Error!");
		echo json_encode($rs);
		exit;
	}
	else {
		$rs = Array("errorMsg"=>"SQL Error!");
		echo json_encode($rs);
		exit;
	}
}
?>