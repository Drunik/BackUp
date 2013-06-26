<?php

	include_once('db_ini.php');

//	mysql_query(" UPDATE client_list SET name = 'цц' WHERE id = 31 ");
	header('Content-Type: text/html; charset=utf-8');
		if($_GET['q']){
			$key = trim($_GET['q']);
			if (strlen(trim($key))>=1){
				$name_query = " SELECT DISTINCT name FROM client_list WHERE company_id = ".$_GET['comp_id']." AND name LIKE '".$key."%'  ORDER BY name ";   
				echo $name_query;
				$res_name = mysql_query($name_query);
				for($i_=0; $i_<mysql_num_rows($res_name); $i_++){
					$name_ = mysql_result($res_name, $i_, 0);
					print $name_."|0|0\n";
				}
			}
		}
?>