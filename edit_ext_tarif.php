<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$period_id = $_GET['period_id'];
	$car_class_id = $_GET['car_class_id'];
	$ratio_1 = $_GET['ratio_1'];
	$ratio_2 = $_GET['ratio_2'];
	$ratio_3 = $_GET['ratio_3'];
	$price_1 = $_GET['price_1'];
	$price_2 = $_GET['price_2'];
	$price_3 = $_GET['price_3'];
	
	$count_query = mysql_query('SELECT * FROM companies_ext_tarifs
					WHERE company_id = "'.$company_id.'"
					AND car_class_id = "'.$car_class_id.'"
					AND period_id = "'.$period_id.'"');
	
	if (mysql_num_rows($count_query) == 0){
		$query = 'INSERT INTO companies_ext_tarifs
				SET	 company_id = "'.$company_id.'"						
					,car_class_id = "'.$car_class_id.'"	
					,period_id = "'.$period_id.'"	
					,ratio_1 = "'.$ratio_1.'"	
					,ratio_2 = "'.$ratio_2.'"	
					,ratio_3 = "'.$ratio_3.'"	
					,price_1 = "'.$price_1.'"	
					,price_2 = "'.$price_2.'"	
					,price_3 = "'.$price_3.'"';
	}
	else{
		$query = 'UPDATE companies_ext_tarifs
				SET
					 ratio_1 = "'.$ratio_1.'"	
					,ratio_2 = "'.$ratio_2.'"	
					,ratio_3 = "'.$ratio_3.'"	
					,price_1 = "'.$price_1.'"	
					,price_2 = "'.$price_2.'"	
					,price_3 = "'.$price_3.'"
				WHERE
					 company_id = "'.$company_id.'" AND car_class_id = "'.$car_class_id.'" AND period_id = "'.$period_id.'"';		
	}

	mysql_query($query);
	
	echo $query."\n".mysql_error().mysql_num_rows($count_query);
?>
