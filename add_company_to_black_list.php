<?php 
	session_start();
	include_once('db_ini.php');
	$user_id    = $_GET['user_id'];
	$company_id_ = $_GET['company_id'];
	$closed_company_ = $_GET['closed_company'];
	
	$query = ' INSERT INTO  black_list_company (owner_company , closed_company , user_id , datetime) VALUES ('.$company_id_.','.$closed_company_.','.$user_id.",'".date("Y-m-d H:i:s")."')";
	mysql_query($query);
	echo $query;			
?>













