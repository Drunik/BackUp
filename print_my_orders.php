<?php 
function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
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
/*	define( '_JEXEC', 1 );
	define('JPATH_BASE', '/home/vtsystemru/domains/vtsystem.ru/public_html'); 
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	$session     = &JFactory::getSession(); 
	*/
    include_once('db_ini.php');
    include('tools.php');
	$user_id_ =   $_GET['user_id'];
	$company_id_ = $_GET['company_id'];
    $query=' SELECT taxi3_orders.order_id, car_classes.class_name, time_pod, time_pod_hours, time_pod_min, '.
   					   ' 0, 0, 0, comment, price, rate, ttl, owners.company_name, customers.company_name, '.
					   ' taxi3_orders.phone, taxi3_orders.client_name, '. 
					   ' drivers.driver_name, cars.model, cars.reg_number, cars.car_name'.
   					   ' FROM taxi3_orders '. 
   					   ' INNER JOIN car_classes '. 
   					   ' ON taxi3_orders.class_id = car_classes.class_id '.
   					   ' INNER JOIN companies owners '.
   					   ' ON owners.company_id = taxi3_orders.company_id '.
   					   ' LEFT OUTER JOIN companies customers '.
   					   ' ON customers.company_id = taxi3_orders.customer_id '.
   					   ' LEFT OUTER JOIN cars ON cars.car_id = taxi3_orders.car_id '.
   					   ' LEFT OUTER JOIN drivers ON drivers.driver_id = taxi3_orders.driver_id '.
					   ' WHERE taxi3_orders.class_id = car_classes.class_id AND finished=0 AND '.
					   ' ((type=1 AND taxi3_orders.company_id='.$company_id_.') OR ( type=2 AND ttl=0 AND customer_id='.$company_id_.') OR ( type=2 AND taxi3_orders.company_id='.$company_id_.' AND ttl=0 AND customer_id=0))  ORDER BY taxi3_orders.order_id DESC';
					   					//   мои заказы которые не пошли на биржу          эти заказы я купил на бирже					      эти заказы я пытался продать но не продал
   if ($user_id_>0){										
	   $res1 = mysql_query($query);
	   $html_.='<table id="my_orders_table" class="show_tables">
			       <thead>
				 <tr class="componentheading">
					<th>№</th>
					<th>Класс</th>
					<th>Время Подачи </th>
					<th>Маршрут Заказа</th>
					<th>Телефон клиента</th>	
					<th>Доп. информация</th>
					<th>Стоимость</th>
					<th>Авто</th>	
				</tr>
			       </thead>
			       <tbody>';
	   echo 'активных заказов: '.mysql_num_rows($res1);	
	   for ($i_=0; $i_<mysql_num_rows($res1); $i_++){
		  $addresses_query = ' SELECT  id, street, house, porch, dolg, shir FROM orders_adr WHERE order_id = '.mysql_result($res1, $i_,0).' ORDER BY sort';
		  $res_adr=mysql_query($addresses_query);	
		  $addresses='';
		  for($j_=0; $j_<mysql_num_rows($res_adr); $j_++){
			 $addresses.=mysql_result($res_adr, $j_,1).', '.mysql_result($res_adr, $j_,2).', '.mysql_result($res_adr, $j_,3).'<BR>' ;
		  }
		  $html_.='<tr> <td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.
							'<a href="#" onclick="edit_order('.DB2Web(mysql_result($res1, $i_,0)).'); return false;">'.
								DB2Web(mysql_result($res1, $i_,0)).
							'</a>'.
				'</td>'.
					 '<td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.
							'<a href="#" onclick="edit_order('.DB2Web(mysql_result($res1, $i_,0)).'); return false;">'.
							 DB2Web(mysql_result($res1, $i_,1)).
							'</a>'.
						 '</td>'.
						 '<td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.
							'<a href="#" onclick="edit_order('.DB2Web(mysql_result($res1, $i_,0)).'); return false;">'.
						 print_date_time(mysql_result($res1, $i_,2), mysql_result($res1, $i_,3), mysql_result($res1, $i_,4)).
							'</a>'.
						 '</td>'.
						 '<td>'.
							'<a href="#" onclick="edit_order('.DB2Web(mysql_result($res1, $i_,0)).'); return false;">'.
							$addresses.
							'</a>'.
							'</td>'.
							'<td align="center" title="'.DB2Web(mysql_result($res1, $i_,15)).'">'.
							'<a href="#" onclick="edit_order('.DB2Web(mysql_result($res1, $i_,0)).'); return false;">'.
							PrepPhone(DB2Web(mysql_result($res1, $i_,14))).
							'</a>'.
							'</td>'.
							'<td >'.
							'<a href="#" onclick="edit_order('.DB2Web(mysql_result($res1, $i_,0)).'); return false;">'.
							DB2Web(mysql_result($res1, $i_,8)).
							'</a>'.
							'</td><td align="center" style="font-size:14px">'.
							DB2Web(mysql_result($res1, $i_,9)).
							' руб.</td>'.
							'<td align="left" title="'.DB2Web(mysql_result($res1, $i_,16)).'">'.
							DB2Web(mysql_result($res1, $i_,18)).
							' '.
							DB2Web(mysql_result($res1, $i_,17)).
							'</td>'.
							'</tr>';
		}  
		$html_.='</tbody></table>';
	   echo $html_;
	}	   
?>
