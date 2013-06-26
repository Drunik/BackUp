<?php 

   $fine_id_    = $_GET['fine_id'];
   $company_id_  = $_GET['company_id'];


	include_once('db_ini.php');
	$txt = mysql_query('UPDATE  fines_entry  SET  status = "agree"  WHERE fines_entry.id = '.$_GET['fine_id']);
	
// сюда надо добавить создание штрафа в расчетах	
	
	echo $txt;
?>

