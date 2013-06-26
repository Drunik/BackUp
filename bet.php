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
  
 //  $mysqli->autocommit(false);
   
   $result  = mysql_query( ' SELECT customer_id, rate, company_id, ttl_adding_start, start_rate FROM taxi3_orders WHERE  ttl>0 AND status = 0 AND order_id = '.$order_id_);

   if (mysql_num_rows($result)>0){
   			$rate = mysql_result($result, 0, 1);
   			$start_rate = mysql_result($result, 0, 4);
   			$ttl_adding_start = mysql_result($result, 0, 3);
			$customer_id = mysql_result($result, 0, 0);
            if ($company_id!=$customer_id){
				if (($rate>$start_rate)||($customer_id>0)){
					$rate = $rate + 1;
				}
				
				$delta =0;	
				if(($ttl_adding_start>90)&&($ttl_adding_start>$ttl)){
					$delta = 5;
				}elseif(($ttl_adding_start>60)&&($ttl_adding_start>$ttl)){
					$delta = 3;
				}
		   		mysql_query(' UPDATE taxi3_orders SET rate='.$rate.', ttl=ttl+'.$delta.', customer_id='.$company_id.' WHERE order_id = '.$order_id_ );
			}	
			mysql_query(' INSERT INTO bet_log (order_id, time_stamp, comp_id, user_id, ip, rate, action_type) VALUES ('.$order_id_.",'".$time_stamp."',".
  					    $company_id.','.$user_id.",'".$ip."',".$rate.', 2) ');	
	}  
?>