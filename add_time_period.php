<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$name = $_GET['name'];
	$time_from_hours = $_GET['time_from_hours'];
	$time_from_min = $_GET['time_from_min'];
	$time_to_hours = $_GET['time_to_hours'];
	$time_to_min = $_GET['time_to_min'];	 
	$distance_1 = $_GET['distance_1'];
	$distance_2 = $_GET['distance_2'];
	$datetime = date("Y-m-d H:i:s");
	
	$query =    'INSERT INTO tarif_time_periods
			SET	 company_id = "'.$company_id.'"
				,name = "'.$name.'"
				,time_from_hours = "'.$time_from_hours.'"
				,time_from_min = "'.$time_from_min.'"
				,time_to_hours = "'.$time_to_hours.'"
				,time_to_min = "'.$time_to_min.'"
				,distance_1 = "'.$distance_1.'"
				,distance_2 = "'.$distance_2.'"
				,user_id = "'.$user_id.'"						
				,datetime = "'.$datetime.'"';	

	mysql_query($query);			
				
	echo $query."\n".mysql_error();
?>
