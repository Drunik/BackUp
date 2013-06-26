<?php 

	session_start();

	include_once('db_ini.php');

	$user_id    = $_POST['user_id'];

	$company_id_ = $_POST['company_id'];

	$client_number_id = $_POST['client_number'];

	$query = mysql_query(" SELECT phone FROM client_list WHERE black_list = 1 AND phone = '".$client_number_id."' ")or die(mysql_error());

	

	if (mysql_num_rows($query)>0){

		echo 'клиент в черном списке';	

	}

//	echo $query;			

?>































