<?php
session_start();
$rs = Array();
if(isset($_SESSION['customer'])){
	$rs['login'] = true;
	$rs['username'] = $_SESSION['customer'];
}
else {
	$rs['login'] = false;
}
echo json_encode($rs);
?>