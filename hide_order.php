<?php 
	
	include_once('db_ini.php');

    $user_id_ = $_GET['user_id'];
	$order_id_ = $_GET['order_id'];
	$value = $_GET['value'];
	
	
	$res = mysql_query(" SELECT id FROM hidden_orders WHERE order_id =".$order_id_." AND user_id=".$user_id_);
	if (mysql_num_rows($res)>0){
		$query= ' UPDATE hidden_orders SET value='.$value.' WHERE order_id ='.$order_id_.' AND user_id='.$user_id_;	
	}else{
		$query= ' INSERT INTO hidden_orders (order_id, user_id, value) VALUE('.$order_id_.', '.$user_id_.','.$value.') ';	
	}
	echo $query;
	mysql_query($query);
?>
