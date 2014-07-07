<?php
//包含数据库连接文件
include_once(dirname(__FILE__) . '/../conn.php');
require_once(dirname(__FILE__) . '/../Bean/Food.php');

class FoodDAO
{
	public function __construct() {
    }
	public function __destruct() {
	   //global $conn;
       //odbc_close($conn);
    }

	public function add_food($food) {
		global $conn;
		$fname = $food->get_name();
		$fprice = $food->get_price();
		$ftype = $food->get_type();
		$picurl = $food->get_picurl();
		$descrip = $food->get_description();
		$sql = "insert into food (foodname, foodprice, foodtype, picurl, descrip)
				values('$fname', $fprice, $ftype, '$picurl', '$descrip')
		";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		return 1;
	}
	public function delete_via_id($fid) {
		global $conn;
		$sql = "delete from food where foodid=$fid ";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		return 1;
	}
	public function get_all_foods() {
		global $conn;
		$sql = "select * from food ";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		$foods = array();
		$num = 0;
		while (odbc_fetch_row($rs)) {
			$food = array();
			for ($i = 1; $i <= 6; $i++){
				$elem = odbc_result($rs, $i);
				$food[$i-1] = $elem;
			}
			$foods[$num] = $food;
			$num += 1;
		}
		return $foods;
	}
	public function get_via_id($fid) {
		global $conn;
		$sql = "select * from food where foodid = $fid ";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		
		$num = 0;
		odbc_fetch_row($rs);
		$food = array();
		for ($i = 1; $i <= 6; $i++){
			$elem = odbc_result($rs, $i);
			$food[$i-1] = $elem;
		}
		return $food;
	}
	public function get_food($fid) {
		global $conn;
		$sql = "select * from food where foodid = $fid ";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		
		$num = 0;
		odbc_fetch_row($rs);
		$food = array();
		for ($i = 1; $i <= 6; $i++){
			$elem = odbc_result($rs, $i);
			$food[$i-1] = $elem;
		}
		return $food;
	}
	public function update_food($food) {
		global $conn;
		$fid = $food->get_id();
		$fname = $food->get_name();
		$fprice = $food->get_price();
		$ftype = $food->get_type();
		$picurl = $food->get_picurl();
		$descrip = $food->get_description();
		//echo $fid . "|" . $fname . "|" . $fprice . "|" . $ftype . "|" . $picurl . "|" . $descrip;
		$sql = "update food set foodname = '$fname', foodprice = $fprice, foodtype = $ftype, 
					picurl = '$picurl', descrip = '$descrip' where foodid = $fid";
		$rs = odbc_exec($conn, $sql);
		if (!$rs)
		{
			return 0;
		}
		return 1;
	}
}
?>