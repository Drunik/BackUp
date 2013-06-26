<?php 
	session_start();
	include_once('db_ini.php');
	$company_id = $_GET['company_id'];
	$name = $_GET['dispetcher_name'];
	$phone = $_GET['dispetcher_phone'];
	$phone = preg_replace("#[^0-9]*#is", "", $phone);
//	$phone = $_GET['dispetcher_phone'];
	$username = $phone;
	$salt = "\x73\x41\x6C\x54";
	$password = md5($phone.$salt);
	$user_type = 'Manager';
	$user_group = 2; //Диспетчеры
	
	$query = 'INSERT INTO jos_users
			SET	 name = "'.$name.'"	
				,username = "'.$username.'"	
				,password = "'.$password.'"	
				,usertype = "'.$user_type.'"	
				,company_id = "'.$company_id.'"
				,phone = "'.$phone.'"
				,user_group = "'.$user_group.'"';	

	mysql_query($query);
	
	echo $query."\n".mysql_error();
?>
