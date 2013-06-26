<?php 
	session_start();
	include_once('db_ini.php');
	$drivers_    = $_GET['driver_id'];
	$company_id_ = $_GET['company_id'];
	$query = ' DELETE FROM drivers '.
			' WHERE driver_id = '.$drivers_.
			' and company_id = '.$company_id_
			;
	mysql_query($query);
	echo $query;			
?>













