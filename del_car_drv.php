<?php 

session_start();
   include_once('db_ini.php');
   
   $car_drv_id    = $_GET['car_drv_id'];
   $company_id_ = $_GET['company_id'];
   mysql_query(' DELETE  FROM drivers_by_car WHERE drivers_by_car_id = '.$car_drv_id.' AND company_id='.$company_id_);
?>



