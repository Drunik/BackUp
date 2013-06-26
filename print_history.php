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
	session_start();
   include_once('db_ini.php');
   $user_id_ =   $_GET['user_id'];
   $company_id_ = $_GET['company_id'];
   $filter_ = $_GET['filter'];
   
   if ($filter_ == 0)
     $filter_str = '((type=1 AND taxi3_orders.company_id='.$company_id_.')
			  OR
			  ( type=2 AND ttl=0 AND customer_id='.$company_id_.')
			  OR
			  ( type=2 AND taxi3_orders.company_id='.$company_id_.' AND ttl=0 AND customer_id=0))';
     
   if ($filter_ == 1)
     $filter_str = '(type=1 AND taxi3_orders.company_id='.$company_id_.')';
     
   if ($filter_ == 2)
     $filter_str = '( type=2 AND ttl=0 AND customer_id='.$company_id_.')';
     
   if ($filter_ == 3)
     $filter_str = '( type=2 AND taxi3_orders.company_id ='.$company_id_.' AND ttl=0 AND customer_id=0)';     
     
     
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
   $query=' SELECT taxi3_orders.order_id, car_classes.class_name, time_pod, time_pod_hours, time_pod_min, '.
   					   ' 0, 0, 0, comment, price, rate, ttl, owners.company_name, customers.company_name, '.
					   ' taxi3_orders.phone, taxi3_orders.client_name, '. 
					   ' drivers.driver_name, cars.model, cars.reg_number '.
   					   ' FROM taxi3_orders '. 
   					   ' INNER JOIN car_classes '. 
   					   ' ON taxi3_orders.class_id = car_classes.class_id '.
   					   ' INNER JOIN companies owners '.
   					   ' ON owners.company_id = taxi3_orders.company_id '.
   					   ' LEFT OUTER JOIN companies customers '.
   					   ' ON customers.company_id = taxi3_orders.customer_id '.
   					   ' LEFT OUTER JOIN cars ON cars.car_id = taxi3_orders.car_id '.
   					   ' LEFT OUTER JOIN drivers ON drivers.driver_id = taxi3_orders.driver_id '.
					   ' WHERE taxi3_orders.class_id = car_classes.class_id AND finished=1 AND '.
					   $filter_str.
					   ' ORDER BY taxi3_orders.order_id DESC ';
					   
   $res1 = mysql_query($query);
   //echo $query;
/*
   $html_='  <table cellspacing="1" cellpadding="1" rules="all" width="700">
	   		<tr  class="componentheading" style="font-size:small">
				<td>№</td>
				<td >класс</td>
		   		<td>время подачи </td>
				<td>маршрут заказа</td>
				<td>комментарий</td>
				<td>стоимость</td>
				<td style="font-size:smaller">%</td>
			</tr>';
*/
   $html_='
     <select id="fines_filter" name="fines_filter" onchange="loadHistory($(this).val());">
	  <option value="0"';
	  if ($filter_ == 0)  $html_.=' selected';
	 $html_.='>Все</option>
	  <option value="1"';
	  if ($filter_ == 1) $html_.=' selected';
	  $html_.='>Мои</option>
	  <option value="2"';
	  if ($filter_ == 2) $html_.=' selected';
	  $html_.='>Купленные</option>
	  <option value="3"';
	  if ($filter_ == 3) $html_.=' selected';
	  $html_.='>Проданные</option>	  
     </select>';        
 
    $html_.='Законченных заказов: '.mysql_num_rows($res1);
   
   $html_.='<table id="history_table" class="show_tables" rules="all">
	   		<tr class="componentheading">
				<th>№</th>
				<th>Класс</th>
		   		<th>Время Подачи </th>
				<th>Маршрут Заказа</th>
				<th>Телефон клиента</th>	
				<th>Доп. информация</th>
				<th>Стоимость</th>
				<th>Авто</th>	
			</tr>';
				
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
	             '<td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.DB2Web(mysql_result($res1, $i_,1)).'</td>'.
				 '<td align="center" title="'.DB2Web(mysql_result($res1, $i_,12)).'">'.print_date_time(mysql_result($res1, $i_,2), mysql_result($res1, $i_,3), mysql_result($res1, $i_,4)).'</td><td>'.
	  					$addresses.
						'</td><td align="center" title="'.DB2Web(mysql_result($res1, $i_,15)).'">'.DB2Web(mysql_result($res1, $i_,14)).'</td>'.
						'</td><td >'.
						DB2Web(mysql_result($res1, $i_,8)).
						'</td><td align="center" style="font-size:16px">'.
						DB2Web(mysql_result($res1, $i_,9)).
						'</td>'.
						'<td align="left" title="'.DB2Web(mysql_result($res1, $i_,16)).'">'.
						DB2Web(mysql_result($res1, $i_,18)).
						' '.
						DB2Web(mysql_result($res1, $i_,17)).
						'</td>'.
						'</tr>';
	}  
	$html_.='</table>';
//	$html_.='</div>';
   echo $html_;
?>
