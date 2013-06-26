<?php	

	include('tools.php');

	
	
	function send_sms($target, $sms_text, $sender, $order_id_, $company_id_, $user_id_){
		global  $sms;
		
		if ((substr($target, 1, 1)=='9')||(substr($target, 1, 4)=='8129')){
		
			$status			= 'sent'; 
			$period=600;
			Include('../sms/QTSMS.class.php');
			$sms= new QTSMS('27354.1','16188233','web.mirsms.ru');
			
			
			$query = ' INSERT INTO  sms_entry (order_id, phone, message, sender, status, company_id, user_id, datetime) VALUES 
											  ("'.$order_id_.'","'.$target.'","'.$sms_text.'","'.$sender.'","'.$status.'","'.$company_id_.'","'.$user_id_.'","'.date("Y-m-d H:i:s").'")';
			mysql_query($query);
			$sms_id = mysql_insert_id();
//			echo $sms_text.'<br>'.$target.'<br>'.$sender.'<br>'.$period.'<br>'.$sms_id;
//			$result=$sms->post_message($sms_txt_, $target, $sender_,$sms_id, $period);
			$result=$sms->post_message($sms_text, $target, $sender, 'x124127456', $period);
		//	$result=$sms->post_message($sms_text, $target, $sender, '33', $period);
//			$result=$sms->status_sms_id($sms_id);
			
			echo $result;
			
			// здесь надо бы отловить доставлена ли смс, снять бабла и изменить статус на "received"
			$sms_cost = -0.35;
			
			mysql_query('INSERT INTO money_orders (company, order_id, summa, comment, type, tarif) VALUES('.$company_id_.','.$order_id_.','.		
							   $sms_cost.',"Стоимость SMS, заказ №'.$order_id_.'", 1,""); ');

			$txt = 'UPDATE companies SET all_sum = all_sum '.$sms_cost.' WHERE company_id = '.$company_id_.' ;';
//			echo $txt;
			mysql_query($txt);
			
			
			


		}
	}
	
	include_once('db_ini.php');
	
	
	$order_id		= $_GET['order_id'];
	$type_sms		= $_GET['type_sms'];
	$company_id_		= $_GET['company_id'];
	$user_id_ 		= $_GET['user_id'];
	
	
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
//	echo $addresses;
	
	$cost = mysql_result($res_info, 0, "cost");
//	echo $cost;

	if (mysql_num_rows($res_info)<=0){
		//  ошибка !!!!		
	}else{
		if ((mysql_result($res_info, 0, "designated_driver")==1) and ($type_sms == 'designated_driver')){
				$sms_txt = fill_sms(mysql_result($res_info, 0, "designated_driver_sms_text"), mysql_result($res_info, 0, "model"), mysql_result($res_info, 0, "reg_number"), mysql_result($res_info, 0, "color"), $addresses, $cost);
				send_sms(mysql_result($res_info, 0, "phone"), $sms_txt, mysql_result($res_info, 0, "company_english_name"), $order_id, $company_id_, $user_id_);
		}
		if ((mysql_result($res_info, 0, "driver_confirm_order")==1) and ($type_sms == 'driver_confirm_order')){
				$sms_txt = fill_sms(mysql_result($res_info, 0, "driver_confirm_order_sms_text"), mysql_result($res_info, 0, "model"), mysql_result($res_info, 0, "reg_number"), mysql_result($res_info, 0, "color"), $addresses, $cost);
				send_sms(mysql_result($res_info, 0, "phone"), $sms_txt, mysql_result($res_info, 0, "company_english_name"), $order_id, $company_id_, $user_id_);
		}
		if ((mysql_result($res_info, 0, "car_filed")==1) and ($type_sms == 'car_filed')){
				$sms_txt = fill_sms(mysql_result($res_info, 0, "car_filed_sms_text"), mysql_result($res_info, 0, "model"), mysql_result($res_info, 0, "reg_number"), mysql_result($res_info, 0, "color"), $addresses, $cost);
				send_sms(mysql_result($res_info, 0, "phone"), $sms_txt, mysql_result($res_info, 0, "company_english_name"), $order_id, $company_id_, $user_id_);
		}
		if ((mysql_result($res_info, 0, "all_cars")==1) and ($type_sms == 'all_cars')){
			
			
			$query_online_car = ' SELECT drivers.driver_phone as driver_phone '.
				' ,drivers_by_car.drivers_by_car_id '.
				' FROM drivers_by_car '.
				' INNER JOIN drivers ON drivers.driver_id = drivers_by_car.driver_id WHERE drivers_by_car.company_id = '.$company_id_;

			
			$res_online_car = mysql_query($query_online_car);

			for($j_=0; $j_<mysql_num_rows($res_online_car); $j_++){
				if ($j_==0) {
					$phone.=''.mysql_result($res_online_car, $j_, "driver_phone");
				} else {
					$phone.=', '.mysql_result($res_online_car, $j_, "driver_phone");
				}
			}
//			echo $phone;			
			

			
			$sms_txt = fill_sms(mysql_result($res_info, 0, "all_cars_sms_text")
					    , mysql_result($res_info, 0, "model")
					    , mysql_result($res_info, 0, "reg_number")
					    , mysql_result($res_info, 0, "color")
					    , $addresses
					    , $cost);
			send_sms($phone, $sms_txt, mysql_result($res_info, 0, "company_english_name"), $order_id, $company_id_, $user_id_);
		}
	}

// если тип смс из настроек совпадет с $type = отправляем смс и запоминаем в таблице sms_entry со статусом sent.
// а также списываем с компании сумму в 35 копеек с баланса
/*
	$res_order = mysql_query('SELECT taxi3_orders.phone 			as phone
					, companies.company_english_name	as sender
					, companies.designated_driver 		as designated_driver
					, companies.driver_confirm_order	as driver_confirm_order
					, companies.car_filed				as car_filed
			     FROM taxi3_orders '.
			   ' INNER JOIN companies ON companies.class_id = taxi3_orders.owner_id'.
			   ' WHERE taxi3_orders.order_id = '.$order_id) or die(mysql_error());
     
	$row_order = mysql_fetch_assoc($res_order);
	$min_sum 	= $row_order['min_sum'];



*/
?>	
