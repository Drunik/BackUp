<?php 

   session_start();
   include_once('db_ini.php');

   $driver_id    = $_GET['driver_id'];
   $car_id    = $_GET['car_id'];
   $company_id_ = $_GET['company_id'];
   $res = mysql_query(' SELECT drivers_by_car_id FROM drivers_by_car'.' WHERE car_id = '.$car_id.' OR driver_id='.$driver_id);
   if (mysql_num_rows($res)==0){
		mysql_query(' INSERT INTO drivers_by_car (driver_id, car_id, company_id) VALUES ('.$driver_id.','.$car_id.','.$company_id_.')');
   }

?>







