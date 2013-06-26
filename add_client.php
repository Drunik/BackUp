<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id_ = $_GET['company_id'];
	$client_phone = "8(".$_GET['client_phone'];
	$client_phone = preg_replace("#[^0-9]*#is", "", $client_phone);
	$client_description = $_GET['client_description'];
	$client_discount = $_GET['client_discount'];
	$client_card_number = $_GET['client_card_number'];
	$client_no_cash = ($_GET['client_no_cash'] == 'true')?"1":"0";
	

	$query = ' INSERT INTO  client_list (phone
					, description
					, no_cash
					, company_id
					, card_number
					, discount
					, user_id
					, datetime) 
	VALUES ("'.$client_phone.'"
		,"'.$client_description.'"
		,"'.$client_no_cash.'"
		,"'.$company_id_.'"
		,"'.$client_card_number.'"
		,"'.$client_discount.'"
		,"'.$user_id.'"
		,"'.date("Y-m-d H:i:s").'")';
	mysql_query($query);
	echo $query;
?>















