<?php 

   $mtime = microtime(true);
   $time = floor($mtime);
   $ms = $mtime - $time;
   $time_stamp = date('Y-m-d H:i:s.', $time).floor($ms*1000);

   session_start();

   //include_once('db_ini.php');

   $order_id_ = $_GET['order_id'];
   $user_id =   $_GET['user_id'];
   $company_id =$_GET['company_id'];

 //  $company_id_ = $_SESSION['company_id'];
 //  $user_id_= $_SESSION['user_id'];


   $ip = $_SERVER['REMOTE_ADDR'];
   
   include_once('db_ini.php');

	mysql_query(' UPDATE taxi3_orders SET ttl=0, customer_id=0, status = 3, type=1 WHERE order_id = '.$order_id_ );
		
	mysql_query(' INSERT INTO bet_log (order_id, time_stamp, comp_id, user_id, ip, rate, action_type) VALUES ('.$order_id_.",'".$time_stamp."',".
				$company_id.','.$user_id.",'".$ip."',".$rate.', 3) ');	

?>