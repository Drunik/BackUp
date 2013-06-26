<script type="text/javascript">
/*
function SendSMS(type_sms, order_id) {
	   var company_id   	= <?php echo $_GET['company_id']; ?>;
	  // var order_id   	= $('#client_order_test').val();
  
	   $.ajax({  
	      url: "./my_source_codes/sendsms.php?user_id=<?php echo $_GET['user_id']?>"
		      +"&order_id="	+order_id
		      +"&type_sms="	+type_sms
		      +"&company_id="	+company_id
		     ,cache: false
		     ,success: function(html){
				$("#debugggg").html(html); 
			 }  
	    });  
     
}     
    
//     проверка правильности СМС
function TestSMS() {
	   var company_id   	= <?php echo $_GET['company_id']; ?>;
	   var order_id   	= $('#client_order_test').val();
	   $.ajax({  
	      url: "./my_source_codes/testsmstext.php?user_id=<?php echo $_GET['user_id']?>"
		      +"&order_id="	+order_id
		      +"&company_id="	+company_id
		     ,cache: false
		     ,success: function(html){
				$("#sms_test_input_point").html(html);
			 }  
	    });  

}
*/	
</script>	



<?php

function fill_sms($sms_, $marka_, $number_, $color_, $addresses_, $cost_){
	$res = str_replace('%марка%', 		$marka_, 	$sms_); 
	$res = str_replace('%номер%', 		$number_, 	$res); 
	$res = str_replace('%цвет%', 		$color_, 	$res); 
	$res = str_replace('%откудакуда%', 	$addresses_, 	$res);
	$res = str_replace('%цена%', 		$cost_, 	$res);
	return $res;
}


function PrepPhone($phone_){
	$res = $phone_;
	if (strlen($phone_)==11){
		$res = substr($phone_, 0, 1).'('.substr($phone_, 1, 3).')'.substr($phone_, 4, 3).'-'.substr($phone_, 7, 2).'-'.substr($phone_, 9, 2);
	}else if (strlen($phone_)==10){
		$res = '('.substr($phone_, 0, 3).')'.substr($phone_, 3, 3).'-'.substr($phone_, 6, 2).'-'.substr($phone_, 8, 2);
	}
	return $res;
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







