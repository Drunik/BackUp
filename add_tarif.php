<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$car_class_id = $_GET['car_class_id'];
	$min_sum = $_GET['min_sum'];
	$min_km = $_GET['min_km'];
	$base_price = $_GET['base_price'];
	
	$query = 'INSERT INTO companies_tarifs
			SET	 company_id = "'.$company_id.'"
				,user_id = "'.$user_id.'"						
				,car_class_id = "'.$car_class_id.'"	
				,min_sum = "'.$min_sum.'"	
				,min_km = "'.$min_km.'"	
				,base_price = "'.$base_price.'"';	

	mysql_query($query);
	
	// Считаем количество классов машин компании
	$num_classes = mysql_query('SELECT id FROM companies_tarifs WHERE company_id = "'.$company_id.'"');
	// Если сущ. только один класс, то назначаем его по умолчанию
	if (mysql_num_rows($num_classes) == 1)
		mysql_query('UPDATE companies SET default_car_class = "'.$car_class_id.'" WHERE company_id = "'.$company_id.'"');
		
//	echo $query."\n".mysql_error();
?>
