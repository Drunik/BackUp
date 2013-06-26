<?php 
include_once('db_ini.php');
   
   $res_set = mysql_query(' SELECT driver_id, car_id FROM drivers_by_car WHERE drivers_by_car_id = '.$_GET['driver_set_id']);
	
	$txt = ' SELECT driver_id, car_id FROM drivers_by_car WHERE drivers_by_car_id = '.$_GET['driver_set_id'];

//	if (mysql_num_rows($res_set)>0){
		mysql_query(' UPDATE taxi3_orders SET driver_id = '.mysql_result($res_set, 0, 0).', car_id='.mysql_result($res_set, 0, 1).', '. 
					' order_status = '.$_GET['order_status'].' WHERE order_id = '.$_GET['order_id']);
	
		$txt .=' UPDATE taxi3_orders SET driver_id = '.mysql_result($res_set, 0, 0).', car_id='.mysql_result($res_set, 0, 1).', '. 
					' order_status = '.$_GET['order_status'].' WHERE order_id = '.$_GET['order_id'];
//	}
	
	echo $txt;
?>
