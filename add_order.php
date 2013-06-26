<?php 
//	$date_pod_ = DateTime::createFromFormat('d-m-Y', $_POST['time_pod']);
	include_once('../db_ini.php');
	session_start();
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
			   ' finished, penalty, status, company_id, type, start_auction, start_rate, ttl_adding_start, entry) VALUES ( ';

	$phone="8(".$_POST['phone'];
	$phone = preg_replace("#[^0-9]*#is", "", $phone);

	$ins_query.= $_SESSION['user_id'].", 0, ".$rate.", ".$ttl.", ".$_POST['total_price'].", ".$_POST['distance'].", ".$_POST['class_auto'].",'".$phone.
				"','".$_POST['client_name']."','".$date_pod_."','".$_POST['time_pod_hours']."','".
				 $_POST['time_pod_min']."','".$_POST['urgent']."','";	

	$ins_query.=$_POST['comment']."','".
				(($_POST['no_smoking'])?1:0)."','".(($_POST['help'])?1:0)."','".(($_POST['smoking'])?1:0)."','".(($_POST['curier'])?1:0)."','".
				(($_POST['inomarka'])?1:0)."','".(($_POST['trezv_driver'])?1:0)."','".(($_POST['animal'])?1:0)."','".(($_POST['clear_car'])?1:0)."','".
				(($_POST['luggage'])?1:0)."','".(($_POST['no_shashki'])?1:0)."','".(($_POST['child_armchair_do_15'])?1:0)."','".(($_POST['skin_salon'])?1:0)."','".
				(($_POST['child_armchair_bolee_15'])?1:0)."','".(($_POST['transfert_table'])?1:0)."','".(($_POST['condit'])?1:0)."','".(($_POST['kvit'])?1:0).
				"', 0, 0, 0, ".$_SESSION['company_id'].",".$type.", now(), ".$rate.",".$ttl_adding_start." , ".(($_POST['entry'])?1:0).")";	

	mysql_query($ins_query);

	$last_ins_order_id = mysql_insert_id();
	$upd_query=" UPDATE orders_adr SET order_id = ".$last_ins_order_id." WHERE order_id = 0 AND session_id='".$_POST['sid']."'";
	mysql_query($upd_query);
	
	//внесение телефона клиента  в таблицу client_list
	
	$client_query = " SELECT id, name FROM client_list WHERE phone = '".$phone."' AND company_id = ".$_SESSION['company_id'];
//	echo $client_query;
	$res_clnt = mysql_query($client_query);
	if (mysql_num_rows($res_clnt)>0){
		if ((strlen(mysql_result($res_clnt, 0, "name"))<=0)&&(strlen($_POST['client_name'])>0)){
			mysql_query(" UPDATE client_list SET name = '".$_POST['client_name']."' WHERE id=".mysql_result($res_clnt, 0, "id"));
		}
	}else{
		mysql_query(" INSERT INTO client_list (phone, company_id, name)  VALUES ('".$phone."',".$_SESSION['company_id'].",'".$_POST['client_name']."')");
	}
	
	header('Location: ../main.php');	   
}

?>