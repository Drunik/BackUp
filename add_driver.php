<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id_ = $_GET['company_id'];
	$driver_name = $_GET['driver_name'];
	$driver_phone = "8(".$_GET['driver_phone'];
	$driver_phone = preg_replace("#[^0-9]*#is", "", $driver_phone);
	

	$res_drivers = mysql_query(' SELECT drivers.driver_id FROM drivers ORDER BY  drivers.driver_id DESC  ');
								
	$drivers_num = mysql_result($res_drivers, 0,0) + 1;							


	
	
	$query = ' INSERT INTO  drivers (driver_id
								, driver_name
								, driver_phone
								, company_id
								, user_id
								,datetime) 
	VALUES ("'.$drivers_num.'"
		,"'.$driver_name.'"
		,"'.$driver_phone.'"
		,"'.$company_id_.'"
		,"'.$user_id.'"
		,"'.date("Y-m-d H:i:s").'")';
	mysql_query($query);
	echo $query;
	
?>















