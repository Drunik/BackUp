<?php 
	session_start();
	include_once('db_ini.php');
	$client_id_    = $_GET['client_id'];
	$company_id_ = $_GET['company_id'];
	$query = ' DELETE FROM client_list '.
			' WHERE id = '.$client_id_.
			' and company_id = '.$company_id_
			;
	mysql_query($query);
	echo $query;
?>













