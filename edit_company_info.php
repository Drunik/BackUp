<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id = $_GET['company_id'];
	$info_id = $_GET['info_id'];
	$info_text = preg_replace("/\"/", "'", $_GET['info_text']);
	

	$query = 'UPDATE companies SET '.$info_id.' = "'.$info_text.'" WHERE company_id = "'.$company_id.'"';	

	mysql_query($query);

	echo $query."\n".mysql_error();
?>
