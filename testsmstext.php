<?php	

	include('tools.php');
	include_once('db_ini.php');
	
	
	$order_id		= $_GET['order_id'];
	$type_sms		= $_GET['type_sms'];
	$company_id_		= $_GET['company_id'];
	$user_id_ 		= $_GET['user_id'];
	$test_sms		= $_GET['test_sms'];
	
// надо сделать поиск по ордеру. Получить номер клиента (кому отправлять СМС) и название компании владельца заказ(от имени какой компании будем отправлять)
//+ настройки (какие типы смс эта компания отправляет)
	$query_info = ' SELECT taxi3_orders.phone as phone '.
		' ,taxi3_orders.price as cost '.
		' ,companies.company_english_name as company_english_name '.
		' ,companies.home_city as home_city '.
		' ,companies.designated_driver as designated_driver'.
		' ,companies.driver_confirm_order as driver_confirm_order'.
		' ,companies.car_filed as car_filed'.
		' ,companies.all_cars as all_cars '.
		' ,companies.designated_driver_sms_text as designated_driver_sms_text'.
		' ,companies.driver_confirm_order_sms_text as driver_confirm_order_sms_text'.
		' ,companies.car_filed_sms_text as car_filed_sms_text'.
		' ,companies.all_cars_sms_text as all_cars_sms_text'.
		' ,cars.model as model'.
		' ,cars.reg_number as reg_number'.
		' ,cars.color as color'.
		' FROM taxi3_orders '.
		' INNER JOIN companies ON companies.company_id = taxi3_orders.company_id '.
		' LEFT OUTER JOIN cars ON cars.car_id = taxi3_orders.car_id '.
		' WHERE taxi3_orders.order_id = '.$order_id;

	$res_info = mysql_query($query_info);
	
	$addresses_query = ' SELECT  id, street, house, porch, dolg, shir FROM orders_adr WHERE order_id = '.$order_id.' ORDER BY sort';
	$res_adr=mysql_query($addresses_query)or die(mysql_error());	
	$addresses='';
	$home_city = mysql_result($res_info, 0, "home_city").', ';
	
	for($j_=0; $j_<mysql_num_rows($res_adr); $j_++){
		if ($j_!=0){
			$addresses.= '-> ';	
		}
		$addresses.=str_replace($home_city, '', mysql_result($res_adr, $j_,1));
		if (mysql_result($res_adr, $j_,2) != ''){
			$addresses.=', '.mysql_result($res_adr, $j_,2);
		}
		if (mysql_result($res_adr, $j_,3) != ''){
			$addresses.=', '.mysql_result($res_adr, $j_,3);
		}
	}
	
	$cost = mysql_result($res_info, 0, "cost");

	$sms_txt1 = fill_sms(mysql_result($res_info, 0, "designated_driver_sms_text"), mysql_result($res_info, 0, "model"), mysql_result($res_info, 0, "reg_number"), mysql_result($res_info, 0, "color"), $addresses, $cost);
	
	$sms_txt2 = fill_sms(mysql_result($res_info, 0, "driver_confirm_order_sms_text"), mysql_result($res_info, 0, "model"), mysql_result($res_info, 0, "reg_number"), mysql_result($res_info, 0, "color"), $addresses, $cost);
	
	$sms_txt3 = fill_sms(mysql_result($res_info, 0, "car_filed_sms_text"), mysql_result($res_info, 0, "model"), mysql_result($res_info, 0, "reg_number"), mysql_result($res_info, 0, "color"), $addresses, $cost);
	
	$sms_txt4 = fill_sms(mysql_result($res_info, 0, "all_cars_sms_text")
						, mysql_result($res_info, 0, "model")
						, mysql_result($res_info, 0, "reg_number")
						, mysql_result($res_info, 0, "color")
						, $addresses
						, $cost);
	
?>
<script>
	document.getElementById('designated_driver_sms_text_test').value 	= '<?php echo $sms_txt1;?>';
	document.getElementById('driver_confirm_order_sms_text_test').value 	= '<?php echo $sms_txt2;?>';
	document.getElementById('car_filed_sms_text_test').value 		= '<?php echo $sms_txt3;?>';
	document.getElementById('all_cars_sms_text_test').value 		= '<?php echo $sms_txt4;?>';
</script>
	
