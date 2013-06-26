<?php 

   include_once('db_ini.php');
   $order_id_ = $_GET['order_id'];
   mysql_query(' UPDATE taxi3_orders SET ttl = 0 WHERE taxi3_orders.order_id = '.$order_id_);


?>