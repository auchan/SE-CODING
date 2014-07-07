<?php
if($_POST){

	include('../Service/FoodService.php');

	extract($_POST);

	$deletes = New FoodService();
	$delete_rs = $deletes->delete_food($fid);
	if ($delete_rs == 1) {
		$rs = Array("success"=>true);
		echo json_encode($rs);
		exit;
	}
	else{
		$rs = Array("success"=>false, "errorMsg"=>"SQL Error.");
		echo json_encode($rs);
		exit;
	}
}
?>