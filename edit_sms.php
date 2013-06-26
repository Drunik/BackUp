<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$sms_id = $_GET['sms_id'];
	$sms_value = $_GET['sms_value'];

	$query = 'UPDATE
			companies
		SET
			'.$sms_id.' = "'.$sms_value.'"
		WHERE company_id = "'.$company_id.'"';	

	mysql_query($query);

	echo $query."\n".mysql_error();
?>
