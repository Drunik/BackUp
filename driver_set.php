<?php 
	include_once('db_ini.php');
    $res_set = mysql_query(' SELECT driver_id, car_id FROM drivers_by_car WHERE drivers_by_car_id = '.$_GET['driver_set_id']);
    $txt = ' SELECT driver_id, car_id FROM drivers_by_car WHERE drivers_by_car_id = '.$_GET['driver_set_id'];

//	if (mysql_num_rows($res_set)>0){
    
    if ($_GET['driver_set_id'] == 0){
        $driver_id = 0;
        $car_id = 0;
    }
    else{
        $driver_id = mysql_result($res_set, 0, 0);
        $car_id = mysql_result($res_set, 0, 1);   
    }
    
	mysql_query(' UPDATE taxi3_orders SET driver_id = '.$driver_id.', car_id='.$car_id.', '. 
				' order_status = '.$_GET['order_status'].' WHERE order_id = '.$_GET['order_id']) or die(mysql_error());

    	$txt .=' UPDATE taxi3_orders SET driver_id = '.$driver_id.', car_id='.$car_id.', '. 
				' order_status = '.$_GET['order_status'].' WHERE order_id = '.$_GET['order_id'];
	
	echo $txt;
?>
