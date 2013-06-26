<?php
function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
     //return iconv($in_,$out_,stripslashes($text_));
     return stripslashes($text_);
}
function Web2DB( $text_){
     $in_="UTF-8";
	 $out_="Windows-1251";
     //return iconv($in_, $out_,  $text_ );
     //return addslashes($text_);
	 //return iconv($in_,$out_,addslashes($text_));
	 return addslashes($text_);
}

	include_once('db_ini.php');

	$adr_query = " SELECT id FROM  oper_adr WHERE adr_number =".$_POST['num']." AND user_id =".$_POST['user_id']."  ";
	$res = mysql_query($adr_query);
	
	echo $adr_query;
	
	if (mysql_num_rows($res)>0){
		$set_query= " UPDATE oper_adr SET street = '".Web2DB($_POST['street'])."' WHERE user_id=".$_POST['user_id']." AND adr_number =".$_POST['num'];
	}else{
		$set_query= " INSERT INTO oper_adr (user_id, adr_number, street) VALUES (".$_POST['user_id'].", ".$_POST['num'].", '".Web2DB($_POST['street'])."')"; 
	}
	mysql_query($set_query);
	echo '<BR>'.$set_query;
?>