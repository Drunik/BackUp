<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$car_class_id = $_GET['car_class_id'];
	$min_sum = $_GET['min_sum'];
	$min_km = $_GET['min_km'];
	$base_price = $_GET['base_price'];
	$tarif_id = $_GET['tarif_id'];
	
	$query = 'UPDATE companies_tarifs
			SET	 company_id = "'.$company_id.'"
				,user_id = "'.$user_id.'"						
				,car_class_id = "'.$car_class_id.'"	
				,min_sum = "'.$min_sum.'"	
				,min_km = "'.$min_km.'"	
				,base_price = "'.$base_price.'"
		WHERE company_id = "'.$company_id.'" AND car_class_id = "'.$car_class_id.'"';	

	mysql_query($query);

//	echo $query."\n".mysql_error();
?>
