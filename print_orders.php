<?php 
function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
    //return iconv($in_,$out_,stripslashes($text_));
     return stripslashes($text_);
}
function print_date_time($date_, $hours_, $min_){
	$date_pod = strtotime($date_);
	$date_time_pod = $date_pod + $hours_*3600+$min_*60;
	$today_time = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
	if ($date_pod==$today_time){
	   $res = ' сегодня '; 
	}elseif ($date_pod==$today_time+86400){
	   $res = ' завтра ' ;
	}elseif ($date_pod==$today_time+2*86400){
	   $res = ' послезавтра ' ;
	}
    return  $res.date('d-m-Y H:i',$date_time_pod);
}
//session_start();
  /* 
   $link = mysql_connect('localhost', 'fedtaxiru', '6Rnb2JXdS')or die("Could not connect: " . mysql_error());
   $dbname='fedtaxiru';
   mysql_select_db($dbname);
   */
   include_once('db_ini.php');
   $user_id_ =   $_GET['user_id'];
   $company_id_ =$_GET['company_id'];
   /*
     $db =& JFactory::getDBO(); 
	 $my = $mainframe->getUser();
	 $user_id_= $my->id;
	 $company_id_ = getCompId($my->id, $db);
	 */
 //   $_SESSION['user_id'] = 
 //  $company_id_ = $_SESSION['company_id'];
 //  $user_id_= $_SESSION['user_id'];
	//echo "user = ".$user_id_."; comp = ".$company_id_;
//   $order_id_ = $_GET['order_id'];
//   номер заказа	класс	дата и время подачи	маршрут заказа	комментарий к заказу	стоимость заказа	ставка	%	TTL
//    mysql_query(' UPDATE taxi3_orders SET ttl = 120 - now()+create_date WHERE ttl>0 AND status=0 AND now()-create_date<120 ');
//    mysql_query(' UPDATE taxi3_orders SET ttl = 300 - (SYSDATE()-start_auction) WHERE ttl>0 AND status=0 ');
 //  mysql_query(' UPDATE taxi3_orders SET ttl = 300 - TIMESTAMPDIFF(SECOND, now(), start_auction) WHERE ttl>0 AND status=0 ');
   $res1 = mysql_query(' SELECT taxi3_orders.order_id, car_classes.class_name, time_pod, time_pod_hours, time_pod_min, '.
   					   ' 0, 0, 0, comment, price, rate, ttl, owners.company_name, customers.company_name, taxi3_orders.company_id, '.
					   ' taxi3_orders.customer_id, hidden_orders.value '.
   					   ' FROM taxi3_orders '. 
   					   ' INNER JOIN car_classes '. 
   					   ' ON taxi3_orders.class_id = car_classes.class_id '.
   					   ' INNER JOIN companies owners '.
   					   ' ON owners.company_id = taxi3_orders.company_id '.
   					   ' LEFT OUTER JOIN companies customers '.
  					   ' ON customers.company_id = taxi3_orders.customer_id '.
   					   ' LEFT OUTER JOIN hidden_orders '.
  					   ' ON ( hidden_orders.order_id = taxi3_orders.order_id AND hidden_orders.user_id ='.$_GET['user_id'].' ) '.					   
					   ' WHERE taxi3_orders.class_id = car_classes.class_id '.
					   ' AND ttl>0 AND status = 0 AND type=2 ORDER BY taxi3_orders.order_id DESC ');
				
/*	$user_name= ' SELECT companies.company_name, jos_users.name, companies.test_period_to'.
							' FROM jos_users '. 
							' INNER JOIN companies ON companies.company_id = jos_users.company_id'.
							' WHERE id = '.$_GET['user_id'];
	if ($_GET['user_id']>0){						
		$res_user_name = mysql_query($user_name);
		$test_period_to_ = mysql_result($res_user_name, 0,2);
		if (mysql_num_rows($res_user_name)==1){
			echo 'Компания: '.mysql_result($res_user_name, 0,0);
			echo '<br>';
			echo 'ФИО: '.mysql_result($res_user_name, 0,1);
			echo '<br>';
			echo 'Тестовый период до : ' .$test_period_to_;
			echo '<br>';
			$dt=date('Y-m-d');
			echo "Текущая дата и время на сервере: $dt";
			echo '<br>';
			if ($dt < $test_period_to_){
				$test_period_to_ = strtotime($test_period_to_);
				$dt = strtotime("now");
				$days = ($test_period_to_ - $dt)/ (60*60*24);
				$round_days = round($days);
				echo 'До окончания тестового периода осталось: '.$round_days.' ';	
				if ($round_days == 1){
					echo 'день.';
				} else
				if ($round_days == 2 or $round_days == 3 or $round_days == 4){
					echo 'дня.';
				} else{
					echo 'дней.';
				};
			}
		}
	}			
	echo '<br>';*/
	echo 'всего заказов: '.mysql_num_rows($res1);	
	
   $html_='<table id="print_orders_table" class="show_tables" rules="all">
	   		<tr class="componentheading">
				<th>№</th>
				<th>Класс</th>
		   		<th>Время подачи </th>
				<th>Маршрут заказа</th>
				<th>Доп. информация</th>
				<th>Стоимость</th>
				<th>Ставка обмена</th>
				<th>Время</th>
			</tr>';
   for ($i_=0; $i_<mysql_num_rows($res1); $i_++){
   		if(!mysql_result($res1, $i_, 16 )==1){
		  $addresses_query = ' SELECT  id, street, house, porch, dolg, shir FROM orders_adr WHERE order_id = '.mysql_result($res1, $i_,0).' ORDER BY sort';
		  $res_adr=mysql_query($addresses_query);	
		  $addresses='';
		  for($j_=0; $j_<mysql_num_rows($res_adr); $j_++){
			 $addresses.=mysql_result($res_adr, $j_,1).', '.mysql_result($res_adr, $j_,2).', '.mysql_result($res_adr, $j_,3).'<BR>' ;
		  }
		  $html_.='<tr><td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.DB2Web(mysql_result($res1, $i_,0)).'</td>'.
					  '<td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.DB2Web(mysql_result($res1, $i_,1)).'</td>'.
					  '<td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.print_date_time(mysql_result($res1, $i_,2), mysql_result($res1, $i_,3), mysql_result($res1, $i_,4)).'</td><td>'.
							$addresses.'</td><td>'.
							DB2Web(mysql_result($res1, $i_,8)).'</td><td align="center" style="font-size:16px">'.DB2Web(mysql_result($res1, $i_,9)).' р.</td>';
							$link = "";
							if (mysql_result($res1, $i_,14)==$company_id_){     // отмена договора
								$html_.='<td  align="center" title="'.DB2Web(mysql_result($res1, $i_,13)).'">'.
										'<a href="javascript:void(0);" onclick="cancel_order('.mysql_result($res1, $i_,0).', '.$user_id_.', '.$company_id_.');return false;">'.
										'<img src="./img/del_icon.png" width="20" height="20">'.
										'</a>&nbsp;'.
										DB2Web(mysql_result($res1, $i_,10)).'<br>'.
										DB2Web(mysql_result($res1, $i_,12)).'</td>';
							}elseif(mysql_result($res1, $i_,15)==$company_id_){
								$html_.='<td  align="center" title="'.DB2Web(mysql_result($res1, $i_,13)).'">'.
										DB2Web(mysql_result($res1, $i_,10)).'</td>';
							}else{
								$html_.='<td  align="center" title="'.DB2Web(mysql_result($res1, $i_,13)).'">'.
										'<a href="javascript:void(0);" onclick="bet('.mysql_result($res1, $i_,0).', '.$user_id_.', '.$company_id_.');return false;">'.
										'<img src="./img/up.png" width="20" height="20">'.
										'</a>&nbsp;'.DB2Web(mysql_result($res1, $i_,10)).'</td>';
							}
							$html_.='<td  align="center" title="'.DB2Web(mysql_result($res1, $i_,13)).'">'.DB2Web(mysql_result($res1, $i_,11)).'</td><td>'.
							
							
                    	'<a a href onclick="hide('.mysql_result($res1, $i_,0).', 1); return false">'.
                        	'<span id="fine_set_button" class="button">Скрыть</span>'.
                        '</a>'.
							
							
							
							'</td></tr>';
		}
	}  
	$html_.='</table>';
	echo $html_;
?>
