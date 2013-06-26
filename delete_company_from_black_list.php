<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id_ = $_GET['company_id'];
	$closed_company_ = $_GET['closed_company'];
	
	$query = ' DELETE FROM black_list_company '.
			' WHERE owner_company = '.$company_id_.
			' and closed_company = '.$closed_company_
			;
	mysql_query($query);
	echo $query;			
?>













