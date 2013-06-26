<?php 
	session_start();
	include_once('db_ini.php');
	$id = $_GET['id'];
	
	$query = 'DELETE FROM jos_users	WHERE id = "'.$id.'"';	

	mysql_query($query);
	
//	echo $query."\n".mysql_error();
?>
