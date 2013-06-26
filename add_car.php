<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id_ = $_GET['company_id'];
	$car_name = $_GET['car_name'];
	$car_model = $_GET['car_model'];
	$car_nomer = $_GET['car_nomer'];
	$car_color = $_GET['car_color'];
	$car_type = $_GET['car_type'];
	$car_classes = $_GET['car_classes'];
	

	$res_cars = mysql_query(' SELECT cars.car_id FROM cars ORDER BY  cars.car_id DESC  ');
								
	$cars_num = mysql_result($res_cars, 0,0) + 1;							


	
	
	$query = ' INSERT INTO  cars (car_id
								, model
								, class_id
								, reg_number
								, company_id
								, color
								, car_type
								, car_name
								, user_id
								,datetime) 
	VALUES ("'.$cars_num.'"
		,"'.$car_model.'"
		,"'.$car_classes.'"
		,"'.$car_nomer.'"
		,"'.$company_id_.'"
		,"'.$car_color.'"
		,"'.$car_type.'"
		,"'.$car_name.'"
		,"'.$user_id.'"
		,"'.date("Y-m-d H:i:s").'")';
	mysql_query($query);
	echo $query;
?>















