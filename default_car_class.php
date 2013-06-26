<?php 
	session_start();
	include_once('db_ini.php');
	$default_car_class    = $_GET['default_car_class'];
	$company_id = $_GET['company_id'];
	
	$query = 'UPDATE companies
			SET	 default_car_class = "'.$default_car_class.'"
			WHERE company_id = "'.$company_id.'"';	

	mysql_query($query);

//	echo $query."\n".mysql_error();
?>
