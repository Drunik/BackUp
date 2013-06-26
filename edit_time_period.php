<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$time_period_id = $_GET['time_period_id'];	
	$name = $_GET['name'];
	$time_from_hours = $_GET['time_from_hours'];
	$time_from_min = $_GET['time_from_min'];
	$time_to_hours = $_GET['time_to_hours'];
	$time_to_min = $_GET['time_to_min'];
	$distance_1 = $_GET['distance_1'];
	$distance_2 = $_GET['distance_2'];
	
	$query =	'UPDATE
				tarif_time_periods
			SET
				 name = "'.$name.'"
				,time_from_hours = "'.$time_from_hours.'"						
				,time_from_min = "'.$time_from_min.'"	
				,time_to_hours = "'.$time_to_hours.'"	
				,time_to_min = "'.$time_to_min.'"	
				,distance_1 = "'.$distance_1.'"
				,distance_2 = "'.$distance_2.'"
			WHERE
				id = "'.$time_period_id.'"';	

	mysql_query($query);

	echo $query."\n".mysql_error();
?>
