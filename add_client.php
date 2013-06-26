<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id_ = $_GET['company_id'];
	$client_phone = "8(".$_GET['client_phone'];
	$client_phone = preg_replace("#[^0-9]*#is", "", $client_phone);
	$client_description = $_GET['client_description'];
	$client_no_cash = $_GET['client_no_cash'];
	

	$query = ' INSERT INTO  client_list (phone
								, description
								, no_cash
								, company_id
								, user_id
								,datetime) 
	VALUES ("'.$client_phone.'"
		,"'.$client_description.'"
		,"'.$no_cash.'"
		,"'.$company_id_.'"
		,"'.$user_id.'"
		,"'.date("Y-m-d H:i:s").'")';
	mysql_query($query);
	echo $query;
	
?>















