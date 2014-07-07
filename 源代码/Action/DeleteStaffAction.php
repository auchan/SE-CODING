<?php
if($_POST){

	include('../Service/UserService.php');

	extract($_POST);

	$deletes = New UserService();
	$delete_rs = $deletes->delete_user($uid);
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