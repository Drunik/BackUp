<?php

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


session_start();
include_once('db_ini.php');

$cost = 0;
    
$user_id    	= $_GET['user_id'];
$company_id 	= $_GET['company_id'];
$distance	= $_GET['route_length'];
$hour		= $_GET['time_hours'];
$min		= $_GET['time_min'];
$car_class	= $_GET['class_auto'];
     
     
$res_tarif = mysql_query('SELECT min_sum 	as min_sum
		, min_km 			as min_km
		, base_price			as base_price'.
		' FROM companies_tarifs '.
		' WHERE car_class_id = '.$car_class.' and company_id = '.$company_id) or die(mysql_error());
$row_tarif = mysql_fetch_assoc($res_tarif);

$res_period = mysql_query('SELECT time_from_hours 	as time_from_hours
		, time_from_min 			as time_from_min
		, time_to_hours				as time_to_hours
		, time_to_min				as time_to_min
		, distance_1				as distance_1
		, distance_2				as distance_2
		, id					as id'.
		' FROM tarif_time_periods '.
		' WHERE company_id = '.$company_id) or die(mysql_error());


$res_company = mysql_query(' SELECT luggage_price 	as luggage_price
		, child_armchair_price 			as child_armchair_price
		, entry_price				as entry_price
		, vokzal_price				as vokzal_price
		, airport_price				as airport_price
		, transfert_table_price			as transfert_table_price'.
		' FROM companies '.
		' WHERE companies.company_id = '.$company_id) or die(mysql_error());
	
$row_company = mysql_fetch_assoc($res_company);
		
// Расчет доп. стоимости вокзалов и аэропортов
    $vokzal = $_GET['vokzal'] * $row_company['vokzal_price'];
    $airport = $_GET['airport'] * $row_company['airport_price'];
// Общая стоимость вокзалов и аэропортов  
    $add_cost = $vokzal + $airport;
		
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
			$distance_1 		= $row_period['distance_1'];
			$distance_2		= $row_period['distance_2'];
			$time_from_hours 	= $row_period['time_from_hours'];
			$time_from_min		= $row_period['time_from_min'];
			$time_to_hours		= $row_period['time_to_hours'];
			$time_to_min		= $row_period['time_to_min'];
			$id			= $row_period['id'];
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
//				 $cost = ($distance_1 * $distance_price_1) + ($distance - $distance_1) * $distance_price_2; 		 
				$cost = $min_sum + round($distance_1 - $min_km) * $distance_price_1 + ($distance - $distance_1) * $distance_price_2;
			//	echo 'min_sum= '.$min_sum.', distance1='.$distance_1.',  distance_price_1'.$distance_price_1.', distance = '.$distance.', distance_price_2='.$distance_price_2.', distance_2='.$distance_2;
				
			 	if ($distance > $distance_2) {
//				 больше расстояния2
//			 	 $cost = ($distance_1 * $distance_price_1) + ($distance_2 - $distance_1) * $distance_price_2 + ($distance - $distance_2) * $distance_price_3; 						 
					$cost = $min_sum + round($distance_1 - $min_km) * $distance_price_1 + ($distance_2 - $distance_1) * $distance_price_2 + 
							($distance - $distance_2) * $distance_price_3;
				}			

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


echo $cost+$add_cost;

?>








