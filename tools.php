<?php

function PrepPhone($phone_){

	$res = $phone_;

	if (strlen($phone_)==11){

		$res = substr($phone_, 0, 1).'('.substr($phone_, 1, 3).')'.substr($phone_, 4, 3).'-'.substr($phone_, 7, 2).'-'.substr($phone_, 9, 2);

	}

	return $res;

}

function ShowSMS($type_,$order_id_, $company_id, $test_){

	

	$send_sms = false;

	$res_order = mysql_query('SELECT taxi3_orders.order_id 	as order_id

		 , taxi3_orders.car_id				as car_id

		 , cars.model					as cars_model

		 , cars.reg_number				as cars_reg_number

		 , cars.color					as cars_color'.

		 ' FROM taxi3_orders '.

		 ' INNER JOIN cars ON cars.car_id = taxi3_orders.car_id'.

		 ' WHERE taxi3_orders.order_id = '.$order_id_) or die(mysql_error());

	$res_company = mysql_query('SELECT designated_driver 	as designated_driver

		    , designated_driver_sms_text 	as designated_driver_sms_text

		    , driver_confirm_order		as driver_confirm_order

		    , driver_confirm_order_sms_text	as driver_confirm_order_sms_text

		    , car_filed				as car_filed

		    , car_filed_sms_text		as car_filed_sms_text

		    , company_english_name		as company_english_name

		    , all_cars				as all_cars

  		    , all_cars_sms_text			as all_cars_sms_text'.

		   ' FROM companies '.

		   ' WHERE companies.company_id = '.$company_id) or die(mysql_error());

	$row_order = mysql_fetch_assoc($res_order);

	$row_company = mysql_fetch_assoc($res_company);

	switch ($type_) {

	case 'designated_driver':	$text_= $row_company['designated_driver_sms_text'];	if ($row_company['designated_driver'] == 1) 	{$send_sms = true;}	break;

	case 'driver_confirm_order':	$text_= $row_company['driver_confirm_order_sms_text'];	if ($row_company['driver_confirm_order']) 	{$send_sms = true;}	break;

	case 'car_filed':		$text_= $row_company['car_filed_sms_text'];		if ($row_company['car_filed'])			{$send_sms = true;}	break;

	case 'all_cars':		$text_= $row_company['all_cars_sms_text'];		if ($row_company['all_cars']) 			{$send_sms = true;}	break;

	default:			$text_ = '';

	};

	// отображать что насписано в настройках ($test_ == 'test')

	if (($send_sms == true) or ($test_ == 'test')){

		$string = $text_;

		$search_term = '#марка#';

		$replace_term = $row_order['cars_model'];

		$string = str_replace($search_term,$replace_term,$string);

		$search_term = '#номер#';

		$replace_term = $row_order['cars_reg_number'];

		$string = str_replace($search_term,$replace_term,$string);

		$search_term = '#цвет#';

		$replace_term = $row_order['cars_color'];

		$string = str_replace($search_term,$replace_term,$string);

	}

	return ($string);

	}

function CalcCost($distance,$company_id, $hour ,$min, $car_class){
     
     $cost = 0;
     $res_tarif = mysql_query('SELECT min_sum 	as min_sum
		, min_km 			as min_km
		, base_price			as base_price'.
		' FROM companies_tarifs '.
		' WHERE car_class_id = '.$car_class.' and company_id = '.$company_id) or die(mysql_error());
     $res_period = mysql_query('SELECT time_from_hours 	as time_from_hours
		, time_from_min 			as time_from_min
		, time_to_hours				as time_to_hours
		, time_to_min				as time_to_min
		, distance_1				as distance_1
		, distance_2				as distance_2
		, id					as id'.
		' FROM tarif_time_periods '.
		' WHERE company_id = '.$company_id) or die(mysql_error());


	
	$row_tarif = mysql_fetch_assoc($res_tarif);
	
	$min_sum 	= $row_tarif['min_sum'];
	$min_km 	= $row_tarif['min_km'];
	$base_price	= $row_tarif['base_price'];
	
	if ($distance < $min_km) {
	  // минимальная цена
	   $cost = $min_sum;
	}
	else {
	  // цена
	  $cost = $min_sum + round($distance - $min_km) * $base_price;
	}
	
// расширенная цена по периодам времени

     if (mysql_num_rows($res_period) > 0) {
	 $cost = 0;
		while ($row_period = mysql_fetch_assoc($res_period)){
	       $distance_1 	= $row_period['distance_1'];
	       $distance_2	= $row_period['distance_2'];
	       $time_from_hours = $row_period['time_from_hours'];
	       $time_from_min	= $row_period['time_from_min'];
	       $time_to_hours	= $row_period['time_to_hours'];
	       $time_to_min	= $row_period['time_to_min'];
	       $id		= $row_period['id'];
	       if (($time_from_hours <= $hour) and ($hour <= $time_to_hours)) {
		    if (($time_from_min <= $min) and ($min <= $time_to_min)) {
			 // нашли нужный период
           		 $period_id = $id;
		    }
	       }
	 	}
	 // запускаем расширенный расчет
		 $distance_price_1 = CalcExtCost1($company_id, $car_class, $period_id);
		 $distance_price_2 = CalcExtCost2($company_id, $car_class, $period_id);
		 $distance_price_3 = CalcExtCost3($company_id, $car_class, $period_id);
		 	if ($distance > $distance_1) {
//				 больше расстояния1 и меньше растояния2
				 $cost = ($distance_1 * $distance_price_1) + ($distance - $distance_1) * $distance_price_2; 		 
			 	if ($distance > $distance_2) {
//				 больше расстояния2
			 	 $cost = ($distance_1 * $distance_price_1) + ($distance_2 - $distance_1) * $distance_price_2 + ($distance - $distance_2) * $distance_price_3; 						 }
			 } else 
//				 меньше или равно расстояния1
				if ($distance < $min_km) {
				  // минимальная цена
				   $cost = $min_sum;
				}
				else {
				  // цена
				  $cost = $min_sum + round($distance - $min_km) * $distance_price_1;
				}
	}
    return $cost;
}
function CalcExtCost1($company_id, $car_class, $period_id){
    $res_ext_tarif = mysql_query('SELECT price_1 	as price_1  FROM companies_ext_tarifs '.
		' WHERE car_class_id = '.$car_class.' and period_id = '.$period_id.' and company_id = '.$company_id) or die(mysql_error());
	$row_ext_tarif = mysql_fetch_assoc($res_ext_tarif);
    return $row_ext_tarif['price_1'];
}
function CalcExtCost2($company_id, $car_class, $period_id){
    $res_ext_tarif = mysql_query('SELECT price_2 as price_2  FROM companies_ext_tarifs '.
		' WHERE car_class_id = '.$car_class.' and period_id = '.$period_id.' and company_id = '.$company_id) or die(mysql_error());
	$row_ext_tarif = mysql_fetch_assoc($res_ext_tarif);
    return $row_ext_tarif['price_2'];
}
function CalcExtCost3($company_id, $car_class, $period_id){
    $res_ext_tarif = mysql_query('SELECT price_3 as price_3  FROM companies_ext_tarifs '.
		' WHERE car_class_id = '.$car_class.' and period_id = '.$period_id.' and company_id = '.$company_id) or die(mysql_error());
	$row_ext_tarif = mysql_fetch_assoc($res_ext_tarif);
    return $row_ext_tarif['price_3'];
}

?>







