<?php
	include_once('db_ini.php');
//	header('Content-Type: text/html; charset=utf-8');

//	if($_GET['q']){
		$key = trim($_GET['q']);
//		$street_ = $_GET['street'];
		
		$query_street = "SELECT street FROM oper_adr WHERE adr_number = ".$_GET['num']." AND user_id =".$_GET['user_id'];
		//echo $query_street;
		$res_str = mysql_query($query_street);		
		
		if (mysql_num_rows($res_str)>0){
			$street_= mysql_result($res_str, 0, 0);
			$adr_query = " SELECT DISTINCT number, dolg, shir FROM adress_spb WHERE (number like '".$key."%') AND ( '".$street_."' like CONCAT(town, ', ', street) ) ORDER BY number ASC ";
		}
		$adr_res = mysql_query($adr_query);
		for($i_=0; $i_<mysql_num_rows($adr_res); $i_++){
//			print mysql_result($adr_res, $i_, 0)." ".$street_." "."|".mysql_result($adr_res, $i_, 1)."|".mysql_result($adr_res, $i_, 2)."\n";
			print mysql_result($adr_res, $i_, 0)."|".mysql_result($adr_res, $i_, 1)."|".mysql_result($adr_res, $i_, 2)."\n";
		}
		
		if (mysql_num_rows($adr_res)<=0){
	//		print "нет домов|0|0\n";
		}
//	}
		
?>