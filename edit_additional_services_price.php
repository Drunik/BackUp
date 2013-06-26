<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$service_id = $_GET['service_id'];
	$service_price = $_GET['service_price'];

	$query = 'UPDATE
			companies
		SET
			'.$service_id.' = "'.$service_price.'"
		WHERE company_id = "'.$company_id.'"';	

	mysql_query($query);

	echo $query."\n".mysql_error();
?>
