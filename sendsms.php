<?php	
	Include('../sms/QTSMS.class.php');
	$sms= new QTSMS('27354','16188233','web.mirsms.ru');
	
	$company_id_	= $_GET['company_id'];
	$user_id_ 		= $_GET['user_id'];
	$order_id		= '262';
	$phone			= '+79119130942';
	$message		= 'тест';
	$sender			= 'VTSystemRU';
	$status			= 'sent';
	$company_id		= 151;
	$user_id		= 3;
	echo $order_id;
	$sms_id 		= '27354000000000003';
//	$sms_id 		= 'x124127456';
	$period=600;
	
// 	Отправка СМС сообщения по списку адресатов
//	$result=$sms->post_message($message, $phone, $sender,'x124127456',$period);
//	$result=$sms->status_sms_id($sms_id);
//	echo $result; // результат XML
//	$query = ' INSERT INTO  sms_entry (order_id
//		, phone
//		, message
//		, sender
//		, status
//		, company_id
//		, user_id
//		,datetime) 
//	VALUES ("'.$order_id.'"
//		,"'.$phone.'"
//		,"'.$message.'"
//		,"'.$sender.'"
//		,"'.$status.'"
//		,"'.$company_id.'"
//		,"'.$user_id.'"
//		,"'.date("Y-m-d H:i:s").'")';
//	mysql_query($query);
//	echo $query;
?>	
