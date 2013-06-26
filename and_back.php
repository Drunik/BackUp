<?php
	include_once('db_ini.php');
	function DB2Web( $text_){
		 $out_="UTF-8";
		 $in_="Windows-1251";
		 //return iconv($in_,$out_,stripslashes($text_));
		 return stripslashes($text_);
	}

	$query = " SELECT  id, street, house, porch, dolg, shir, sort FROM orders_adr WHERE session_id='".$_GET['sid']."' AND order_id=0 ORDER BY sort";
	$res = mysql_query($query);

	$res_max = mysql_query(" SELECT MAX(sort) FROM orders_adr WHERE session_id='".$_GET['sid']."' AND order_id=0 ");
	$sort = mysql_result($res_max, 0, 0)+1;

	if (mysql_num_rows($res)>0){
		$ins_query = " INSERT INTO orders_adr (order_id, session_id, street, house, porch, dolg, shir, sort) VALUES(0, '".$_GET['sid']."','".
					 mysql_result($res, 0, "street")."', '".
					 mysql_result($res, 0, "house")."', '".mysql_result($res, 0, "porch")."', ".mysql_result($res, 0, "dolg").', '.
					 mysql_result($res, 0, "shir").', '.$sort.')';
		mysql_query($ins_query);			 
	}	
	echo $ins_query;
?>

