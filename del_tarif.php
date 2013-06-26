<?php 
	session_start();
	include_once('db_ini.php');
	$company_id = $_GET['company_id'];
	$car_class_id = $_GET['car_class_id'];
	
	$query = 'DELETE FROM companies_tarifs
			WHERE	 company_id = "'.$company_id.'"						
			AND	 car_class_id = "'.$car_class_id.'"';	

	mysql_query($query);
	
//	echo $query."\n".mysql_error();
?>
