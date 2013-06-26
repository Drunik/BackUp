<?php 
	function prepNumber($value_){
		return str_replace(",", ".", $value_);
	}
	
	include_once('db_ini.php');

    $company_id_ = $_GET['company_id'];
	$order_id_ = $_GET['order_id'];
	$rate_ = $_GET['rate'];
	$res = mysql_query("SELECT time_pod, time_pod_hours, time_pod_min FROM taxi3_orders WHERE order_id=".$order_id_);
	
	
	
	
	$time_pod = strtotime(mysql_result($res, 0, 0).' '.mysql_result($res, 0, 1).':'.mysql_result($res, 0, 2).':00');
	$date_tek = strtotime("now");
	$dif = ($time_pod-$date_tek)/60;
	if ($dif<=30){
		$ttl_adding_start=0;
		$ttl=60;
	}elseif($dif<=60){
		$ttl_adding_start=88;
		$ttl=90;
	}else{
		$ttl_adding_start=116;
		$ttl=120;
	}
	
	
	
	$query= ' UPDATE taxi3_orders SET type=2, rate='.$rate_.', start_rate='.$rate_.', status = 0, ttl='.$ttl.
			', start_auction=now(), ttl_adding_start='.$ttl_adding_start.', customer_id=0  WHERE order_id = '.$order_id_;
	mysql_query($query);
	echo $query;
?>
