<?php
	include_once('db_ini.php');
/*
	define( '_JEXEC', 1 );
	define('JPATH_BASE', '/home/vtsystemru/domains/vtsystem.ru/public_html'); 
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	$session     = &JFactory::getSession(); 
*/
	$res = mysql_query("SELECT MAX(sort) FROM orders_adr WHERE session_id= '".$_GET['sid']."' AND order_id=0 ");
	$sort = mysql_result($res, 0, 0) + 1;

//	$user_id = trim($_GET['user_id']);
	$query = " DELETE FROM orders_adr WHERE session_id = '".$_GET['sid']."' AND order_id = 0 ";
	mysql_query($query);
	
	echo $query;	
?>	