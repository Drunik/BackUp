<?php 
	session_start();
	include_once('db_ini.php');
	$cars_id_    = $_GET['cars_id'];
	$company_id_ = $_GET['company_id'];
	$query = ' DELETE FROM cars '.
			' WHERE car_id = '.$cars_id_.
			' and company_id = '.$company_id_
			;
	mysql_query($query);
	echo $query;			
?>













