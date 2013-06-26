<?php 



	define( '_JEXEC', 1 );

	define('JPATH_BASE', '/home/vtsystemru/domains/vtsystem.ru/public_html'); 

	define( 'DS', DIRECTORY_SEPARATOR );



	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );

	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

	$session     = &JFactory::getSession(); 

//	$date_pod_ = DateTime::createFromFormat('d-m-Y', $_POST['time_pod']);

	$date_pod_ = $_POST['time_pod'];

	

if (strlen(trim($_POST['phone']))>1){



	$type=$_POST['order_type'];



    if ($type==1){

		$rate=0;

		$ttl=0;

		$ttl_adding_start=0;

	}else{

		$rate=$_POST['rate'];

		$type=2;

		$time_pod = strtotime($date_pod_.' '.$_POST['time_pod_hours'].':'.$_POST['time_pod_min'].':00');

		$date_tek = strtotime("now");

		$dif = ($time_pod-$date_tek)/60;

		if ($dif<=30){

			$ttl_adding_start=0;

			$ttl=60;

		}elseif($dif<=60){

			$ttl_adding_start=88;

			$ttl=90;

		}else{

			$ttl_adding_start=116;

			$ttl=120;

		}

	}



    $ins_query=' INSERT INTO taxi3_orders(owner_id, customer_id, rate, ttl, price, distance, class_id, phone, client_name, time_pod, time_pod_hours, time_pod_min, urgent,'. 

			   ' comment, '.

			   ' no_smoking, help, smoking, curier, inomarka, trezv_driver, animal, clear_car, luggage, no_shashki, child_armchair_do_15, skin_salon,'.

			   ' child_armchair_bolee_15, transfert_table, condit, kvit, '.

			   ' finished, penalty, status, company_id, type, start_auction, start_rate, ttl_adding_start) VALUES ( ';



	$phone="8(".$_POST['phone'];
	$phone = preg_replace("#[^0-9]*#is", "", $phone);
//	$phone = trim($phone);
//	$phone = $phone[1]+$phone[3]+$phone[4]+$phone[5]+$phone[7]+$phone[8]+$phone[9]+$phone[11]+$phone[12]+$phone[14]+$phone[15];



	$ins_query.= $_SESSION['user_id'].", 0, ".$rate.", ".$ttl.", ".$_POST['total_price'].", ".$_POST['distance'].", ".$_POST['class_auto'].",'".$phone."','".$_POST['client_name']."','".$date_pod_."','".$_POST['time_pod_hours']."','".

				 $_POST['time_pod_min']."','".$_POST['urgent']."','";	



	$ins_query.=$_POST['comment']."','".

				(($_POST['no_smoking'])?1:0)."','".(($_POST['help'])?1:0)."','".(($_POST['smoking'])?1:0)."','".(($_POST['curier'])?1:0)."','".

				(($_POST['inomarka'])?1:0)."','".(($_POST['trezv_driver'])?1:0)."','".(($_POST['animal'])?1:0)."','".(($_POST['clear_car'])?1:0)."','".

				(($_POST['luggage'])?1:0)."','".(($_POST['no_shashki'])?1:0)."','".(($_POST['child_armchair_do_15'])?1:0)."','".(($_POST['skin_salon'])?1:0)."','".

				(($_POST['child_armchair_bolee_15'])?1:0)."','".(($_POST['transfert_table'])?1:0)."','".(($_POST['condit'])?1:0)."','".(($_POST['kvit'])?1:0).

				"', 0, 0, 0, ".$_SESSION['company_id'].",".$type.", now(), ".$rate.",".$ttl_adding_start." )";	



	mysql_query($ins_query);

	$last_ins_order_id = mysql_insert_id();



	$upd_query=" UPDATE orders_adr SET order_id = ".$last_ins_order_id." WHERE order_id = 0 AND session_id='".$_POST['sid']."'";



	mysql_query($upd_query);

	header('Location: ./index.php?option=com_content&view=article&id=56&Itemid=51&addpar=orders&act=show');	   

}



function printClasses($class_id, $db){



   $classes_query =  ' SELECT * FROM  car_classes ORDER BY class_id ';

   $db->setQuery( $classes_query );   $temp_result = $db->Query();   $classes_array=$db->loadRowList();

   $txt='';

   for ($i_=0; $i_<$db->getNumRows($temp_result); $i_++){

	   $selected = ''; 

	   if ($classes_array[$i_][0]==$class_id){

	   		$selected =' selected '; 

		}  

       $txt.= '<option value="'.$classes_array[$i_][0].'"'.  $selected.' '.$dis.'>'.$classes_array[$i_][1].'</option>'; 

   }

   return 	$txt;

}



function printMetro($metro_id, $db){

   $metro_query =  ' SELECT * FROM metro ORDER BY metro_name ';

   $db->setQuery( $metro_query );   $temp_result = $db->Query();   $metro_array=$db->loadRowList();

   $txt='';

   for ($i_=0; $i_<$db->getNumRows($temp_result); $i_++){

	   $selected = ''; 

	   if ($metro_array[$i_][0]==$metro_id){

	   		$selected =' selected '; 

		}  

       $txt.= '<option value="'.$metro_array[$i_][0].'"'.  $selected.' '.$dis.'>'.$metro_array[$i_][1].'</option>'; 

   }

   return 	$txt;

}



function printHours($time_pod_hours){

   $txt='';

   for ($i_=0; $i_<24; $i_++){

	   $selected = ''; 

	   if ($i_==$time_pod_hours){

	   		$selected =' selected '; 

		}  

       $txt.= '<option value="'.$i_.'"'.  $selected.' >'.str_repeat("0", 2-strlen($i_)).$i_.'</option>'; 

   }

   return 	$txt;

}



function printMinutes($time_pod_min){

   $txt='';

   for ($i_=0; $i_<60; $i_+=5){

	   $selected = ''; 

	   if ($i_==$time_pod_min){

	   		$selected =' selected '; 

		}  

       $txt.= '<option value="'.$i_.'"'. $selected.' >'.str_repeat("0", 2-strlen($i_)).$i_.'</option>'; 

   }

   return 	$txt;

}







function fillDefCity($city_){

    if (strlen(trim($city_))<1){

		return 'Санкт-Петербург';

	}else{

		return $city_;

	}

}



function fillDefMetro($metro_){

    if (strlen(trim($city_))<1){

		return -1;

	}else{

		return $metro_;

	}

}



function fillDefTime($time_){

    if (strlen(trim($city_))<1){

		return date("Y.m.d");

	}else{

		return $metro_;

	}

}

?>