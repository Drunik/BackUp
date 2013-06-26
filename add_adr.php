<?php
	include_once('db_ini.php');
/*
	define( '_JEXEC', 1 );
	define('JPATH_BASE', '/home/vtsystemru/domains/vtsystem.ru/public_html'); 
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	session_id($_GET['sid']);
	$session     = &JFactory::getSession(); 
	*/
//	$_POST['sort_']
	echo " SELECT id FROM orders_adr WHERE session_id= '".$_POST['sid']."' AND order_id=0 AND sort = ".$_POST['sort_'];
	$res = mysql_query(" SELECT id FROM orders_adr WHERE session_id= '".$_POST['sid']."' AND order_id=0 AND sort = ".$_POST['sort_']);
	if (mysql_num_rows($res)<=0){
		$query = " INSERT INTO orders_adr (session_id, sort, street, house, porch, dolg, shir) VALUES('".$_POST['sid']."', ".$_POST['sort_'].", '".$_POST['str']."', '".$_POST['house']."', '".$_POST['adr_porch']."', ".$_POST['dolg'].", ".$_POST['shir'].") ";
	}else{
		$query = " UPDATE orders_adr SET street = '".$_POST['str']."', house ='".$_POST['house']."', porch='".$_POST['adr_porch']."', dolg=".$_POST['dolg'].
				 ", shir=".$_POST['shir']." WHERE id=".mysql_result($res, 0, 0);
	}
	mysql_query($query);
	echo $query;
?>	