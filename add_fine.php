<?php 
	session_start();
	include_once('db_ini.php');
	
	$fines_id =			$_GET['fines_id'];
	$order_id =			$_GET['order_id'];
	$status =			"disagree";
	$company_from_id = 	$_GET['company_from_id'];
	$user_from_id =		$_GET['user_id'];
	$company_to_id = 	$_GET['company_to_id'];
	$datetime = 		date("Y-m-d H:i:s");
	$comment_from =		$_GET['comment_from'];
	
	$query = ' INSERT INTO `fines_entry` SET fines_id="'.$fines_id.'",
											order_id="'.$order_id.'",
											status="'.$status.'",
											company_from_id="'.$company_from_id.'",
											user_from_id="'.$user_from_id.'",
											company_to_id="'.$company_to_id.'",
											datetime="'.$datetime.'",
											comment_from="'.$comment_from.'"';
	mysql_query($query);
	echo $query;
?>















