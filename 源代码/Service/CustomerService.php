<?php
include_once('../DAO/CustomerDAO.php');

class CustomerService{
	public function add_customer($uid, $customer) {
		$custdao = new CustomerDAO();
		$regdate = time();
		$customer->set_uid($uid);
		$customer->set_regdate($regdate);
		$add_rs = $custdao->add_customer($customer);
		return $add_rs;
	}
}
?>