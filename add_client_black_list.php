<?php 

	session_start();

	include_once('db_ini.php');

	$user_id    = $_POST['user_id'];

	$company_id_ = $_POST['company_id'];

	$client_number_id = $_POST['client_number'];

	$query = " INSERT INTO  client_list (id , company_id , user_id , datetime, black_list ) VALUES ('".$client_number_id."',".$company_id_.",".$user_id.",'".date("Y-m-d H:i:s")."',1)";

	mysql_query($query);

	echo $query;			

?>































