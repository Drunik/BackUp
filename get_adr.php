<?php

	include_once('db_ini.php');

	header('Content-Type: text/html; charset=utf-8');
		if($_GET['q']){
			$key = trim(str_replace('Санкт-Петербург,','', $_GET['q']));
			if (strlen(trim($key))>=1){
				$adr_query = " SELECT DISTINCT street, town FROM adress_spb WHERE (number is not null) AND (length(number)>0) AND (street like '".$key."%') ORDER BY sort, town, street ASC ";   //улицы с домами по началу
				$adr_res = mysql_query($adr_query);
				for($i_=0; $i_<mysql_num_rows($adr_res); $i_++){
					$town_ = mysql_result($adr_res, $i_, 1);
					$street_ = mysql_result($adr_res, $i_, 0);
					print $town_ .", ".$street_."|".$town_ ."|".$street_."|0|0\n";
				}

				$adr_query = " SELECT DISTINCT street, town FROM adress_spb WHERE (number is not null) AND (length(number)>0) AND (street like '% ".$key."%') ORDER BY sort, town, street ASC "; //улицы с домами по началу 2-го слова
				$adr_res = mysql_query($adr_query);
				for($i_=0; $i_<mysql_num_rows($adr_res); $i_++){
					$town_ = mysql_result($adr_res, $i_, 1);
					$street_ = mysql_result($adr_res, $i_, 0);
					print $town_ .", ".$street_."|".$town_ ."|".$street_."|0|0\n";
				}

				$adr_query = " SELECT DISTINCT street, town, shir, dolg FROM adress_spb WHERE ((number is null) OR (length(ltrim(number))<=0)) AND  (street like '".$key."%') ORDER BY sort, town, street ASC "; //объекты без домов по началу
				$adr_res = mysql_query($adr_query);
				for($i_=0; $i_<mysql_num_rows($adr_res); $i_++){
					$town_ = mysql_result($adr_res, $i_, 1);
					$street_ = mysql_result($adr_res, $i_, 0);
					print $town_ .", ".$street_."|".$town_ ."|".$street_."|".mysql_result($adr_res, $i_, 2)."|".mysql_result($adr_res, $i_, 3)."\n";
				}

				$adr_query = " SELECT DISTINCT street, town, shir, dolg FROM adress_spb WHERE ((number is null) OR (length(ltrim(number))<=0)) AND (street like '% ".$key."%') ORDER BY sort, town, street ASC "; //объекты без домов по началу
				$adr_res = mysql_query($adr_query);
				for($i_=0; $i_<mysql_num_rows($adr_res); $i_++){
					$town_ = mysql_result($adr_res, $i_, 1);
					$street_ = mysql_result($adr_res, $i_, 0);
					print $town_ .", ".$street_."|".$town_ ."|".$street_."|".mysql_result($adr_res, $i_, 2)."|".mysql_result($adr_res, $i_, 3)."\n";
				}
			}
		}
?>