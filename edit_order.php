<script type="text/javascript">
function DriverSetCheck() {
	if (document.getElementById('driver_set').value != 0) {
		document.getElementById('status_check').value = 1;
	} else {
		document.getElementById('status_check').value = 0;
	}
}
function ShowPhone(var phone_number) {
	phone_number = phone_number[1]+'('+phone_number[2];
	return phone_number;
}
</script>
<?php 
function printRates(){
   $txt='';
   for ($i_=0; $i_<25; $i_++){
	   $selected = ''; 
	   if ($i_==10){
	   		$selected =' selected '; 
		}  
       $txt.= '<option value="'.$i_.'"'. $selected.' >'.$i_.'</option>'; 
   }
   return 	$txt;	
}
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
   $query=' SELECT taxi3_orders.order_id, 0, 0, time_pod, time_pod_hours, time_pod_min, price, taxi3_orders.phone, '.
					   ' taxi3_orders.client_name, car_classes.class_name, '.
   					   ' 0, comment,  rate, ttl, owners.company_name, customers.company_name,'.
					   ' no_smoking, help, smoking, curier, inomarka, trezv_driver, animal, clear_car, luggage, no_shashki, child_armchair_do_15, skin_salon,'.
					   ' child_armchair_bolee_15, transfert_table, condit, kvit, start_rate, taxi3_orders.company_id, taxi3_orders.customer_id, '.
					   ' taxi3_orders.finished, taxi3_orders.status, driver_id, order_status  '.
   					   ' FROM taxi3_orders '. 
   					   ' INNER JOIN car_classes '. 
   					   ' ON taxi3_orders.class_id = car_classes.class_id '.
   					   ' INNER JOIN companies owners '.
   					   ' ON owners.company_id = taxi3_orders.company_id '.
   					   ' LEFT OUTER JOIN companies customers '.
   					   ' ON customers.company_id = taxi3_orders.customer_id '.
					   ' WHERE taxi3_orders.order_id = '.$_GET['order_id'];
   $log= ' SELECT companies.company_name, jos_users.name, time_stamp, rate'.
			' FROM bet_log '. 
			' INNER JOIN companies ON companies.company_id = bet_log.comp_id'.
			' INNER JOIN jos_users ON jos_users.id = bet_log.user_id'.
			' WHERE order_id = '.$_GET['order_id'];
   $money= ' SELECT comment, tarif, summa'.
			' FROM money_orders '. 
			' WHERE order_id = '.$_GET['order_id'];
	include_once('db_ini.php');
	$res_order = mysql_query($query)or die(mysql_error());
	$res_log   = mysql_query($log)or die(mysql_error());
	$res_money   = mysql_query($money)or die(mysql_error());
//	echo $query;
	$row = mysql_fetch_array($res_order, MYSQL_ASSOC);
	$i_ = 0;
   $company_id_ = $_GET['company_id'];
   $res_set = mysql_query(' SELECT drivers_by_car.drivers_by_car_id
						, drivers.driver_name
						, cars.model
						, cars.reg_number
   						, cars.color
						, cars.car_name
						, cars.car_type
						, drivers.driver_id
					FROM drivers_by_car '.
					' INNER JOIN cars ON cars.car_id = drivers_by_car.car_id'.
					' INNER JOIN car_type ON car_type.id = cars.car_type'.
					' INNER JOIN drivers ON drivers.driver_id = drivers_by_car.driver_id
					WHERE drivers_by_car.company_id = '.$company_id_)or die(mysql_error());
   $client_phone_id_ =  mysql_result($res_order, $i_, 7);
   $client_phone_id = $client_phone_id_[0]."(".$client_phone_id_[1].$client_phone_id_[2].$client_phone_id_[3].")".$client_phone_id_[4].$client_phone_id_[5].$client_phone_id_[6]."-".$client_phone_id_[7].$client_phone_id_[8]."-".$client_phone_id_[9].$client_phone_id_[10];
   $client_phone_number_orders = mysql_query(' SELECT phone FROM taxi3_orders WHERE phone = "'.$client_phone_id_.'"')or die(mysql_error());
   $client_phone_balck_list_set = mysql_query(" SELECT phone FROM client_list WHERE black_list = 1 and phone = '".$client_phone_id_."'")or die(mysql_error());
?>
	<table class="show_tables">
		<tr class="componentheading">
			<th colspan="2">
				Заказ № <?php echo DB2Web(mysql_result($res_order, $i_, 0))?>
			</th>
			<td rowspan="21" >
            Здесь будет полная история по заказу
			<table border="1" align="center">
			<?php if (mysql_num_rows($res_log) != 0){?>
			   <?php for ($l=0; $l<mysql_num_rows($res_log); $l++){?>
					<tr>
						<td>
							<?php echo DB2Web(mysql_result($res_log, $l, 0))?>
						</td>
						<td>
							<?php echo DB2Web(mysql_result($res_log, $l, 3))?>%
						</td>
						<td>
							<?php echo DB2Web(mysql_result($res_log, $l, 2))?>
						</td>
					</tr>
			   <?php }?>
			<?php }?>
			</table>
            <br>
			Конечная ставка =<?php echo DB2Web(mysql_result($res_order, $i_, 12)) ?>% (
			Начальная ставка =<?php echo DB2Web(mysql_result($res_order, $i_, 32)) ?>%)
            <br>
			<?php if (mysql_num_rows($res_money) != 0){?>
				<?php echo DB2Web(mysql_result($res_money, $l, 1))?>
			<?php }?>
            <br>
            Исполнитель: <?php echo DB2Web(mysql_result($res_order, $i_, 6))?>*<?php echo DB2Web(mysql_result($res_order, $i_, 12)) ?>% = <?php echo DB2Web(mysql_result($res_order, $i_, 6))*DB2Web(mysql_result($res_order, $i_, 12))/100 ?>
            <br>
            Система: <?php echo DB2Web(mysql_result($res_order, $i_, 6))?>*0,5% = <?php $Nominal = DB2Web(mysql_result($res_order, $i_, 6))*0.005?> 
            <?php echo $Nominal?>  (за номинал)
            <br>
            + <?php echo DB2Web(mysql_result($res_order, $i_, 6))?> * (<?php echo DB2Web(mysql_result($res_order, $i_, 12))?>%-<?php echo DB2Web(mysql_result($res_order, $i_, 32)) ?>%)*40% = 
            <?php $Torgi = (DB2Web(mysql_result($res_order, $i_, 12))- DB2Web(mysql_result($res_order, $i_, 32))) ?>
            <?php $Torgi1 = $Torgi* DB2Web(mysql_result($res_order, $i_, 6))?>
            <?php $Torgi2 = $Torgi1* 0.004?>
            <?php echo $Torgi2 ?>
            (за торги)
            <br>
            Всего системе:
            <?php echo $Nominal+$Torgi2 ?>
            <br>
			<table border="1" align="center">
			   <?php for ($l=0; $l<mysql_num_rows($res_money); $l++){?>
					<tr>
						<td>
							<?php echo DB2Web(mysql_result($res_money, $l, 0))?>
						</td>
						<td>
							<?php echo DB2Web(mysql_result($res_money, $l, 2))?>
						</td>
					</tr>
			   <?php }?>
			</table>
			</td>
		</tr>
		<tr>
			<th>
				Маршрут	
			</th>
			<td>
				<?php
				   	  $addresses_query = ' SELECT  id, street, house, porch, dolg, shir FROM orders_adr WHERE order_id = '.mysql_result($res_order, $i_, 0).' ORDER BY sort';
	  				  $res_adr=mysql_query($addresses_query)or die(mysql_error());	
					  $addresses='';
	  				  for($j_=0; $j_<mysql_num_rows($res_adr); $j_++){
	  	 					$addresses.=mysql_result($res_adr, $j_,1).', '.mysql_result($res_adr, $j_,2).', '.mysql_result($res_adr, $j_,3).'<BR>' ;
	  					}
				 		echo DB2Web($addresses)?>
			</td>
		</tr>
		<tr>
			<th>
				Стоимость	
			</th>
			<td>
				<?php echo DB2Web(mysql_result($res_order, $i_, 6))?>
			</td>
		</tr>
		<tr>
			<th>
				Время подачи	
			</th>
			<td>
				<?php echo print_date_time(mysql_result($res_order, $i_, 3), mysql_result($res_order, $i_, 4), mysql_result($res_order, $i_, 5)) ?>
			</td>
		</tr>
		<tr>
			<th>
				Класс автомобиля
			</th>
			<td>
				<?php echo DB2Web(mysql_result($res_order, $i_, 9)) ?>
			</td>
		</tr>
		<tr>
			<th>
				Владелец заказа
			</th>
			<td>
				<a onclick="ShowCompany(<?php echo mysql_result($res_order, $i_, 33)?>);">
					<?php echo DB2Web(mysql_result($res_order, $i_, 14)) ?>
                </a>
				<?php if ((mysql_result($res_order, $i_, 14) != '') and (mysql_result($res_order, $i_, 33) != $company_id_))  {?>
                <br>
						<a onclick="Fined_Partner(<?php echo DB2Web(mysql_result($res_order, $i_, 0))?>)">
					    <span id="fined_partner_button" class="button">Оштрафовать партнера по заказу</span>
						</a>
				<?php }?>
			</td>
		</tr>
		<tr>
			<th>
				Исполнитель заказа
			</th>
			<td>
				<p><a onclick="ShowCompany(<?php echo mysql_result($res_order, $i_, 34)?>);">
			    <?php echo DB2Web(mysql_result($res_order, $i_, 15)) ?></a></p>
				<?php if ((mysql_result($res_order, $i_, 15) != '') and (mysql_result($res_order, $i_, 34) != $company_id_))  {?>
                <br>
						<a onclick="Fined_Partner(<?php echo DB2Web(mysql_result($res_order, $i_, 0))?>)">
					    <span id="fined_partner_button" class="button" style="width:130px">Оштрафовать партнера по заказу</span>
						</a>
				<?php }?>
			</td>
		</tr>
		<tr>
			<td colspan="2" width="10">
			</td>
		</tr>		
		<tr class="componentheading">
			<th colspan="2">
				Информация о заказчике
			</th>
		</tr>
		<tr>
			<th>
				Телефон клиента
			</th>
			<td>
		  <?php echo $client_phone_id;
                if (mysql_num_rows($client_phone_balck_list_set) != 0 ){ echo '<br/><span style="color: #f00;">Телефон в черном списке</span>';} 
				else { ?>
					<a onclick="Client_to_Black_List('<?php echo $client_phone_id_?>')">
	                <span class="button" style="width: 110px;padding:0;">В черный список</span>
	                </a>
               <?php }?>
			</td>
		</tr>
		<tr>
			<th>
				Зарегистрировано обращений
			</th>
			<td>
            	<?php echo mysql_num_rows($client_phone_number_orders)?>
			</td>
		</tr>
		<tr>
			<th>
				Имя клиента
			</th>
			<td>
				<?php echo DB2Web(mysql_result($res_order, $i_, 8))?>
			</td>
		</tr>
		<tr>
			<th>
				Доп. информация	
			</th>
			<td>
				<?php echo DB2Web(mysql_result($res_order, $i_, 5))?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox"  name="no_smoking"  id="no_smoking" size="9" <?php if ($row['no_smoking']){ echo 'checked'; }?>  disabled="disabled"/>
				в машине не курить
			</td>
			<td>
				<input type="checkbox"  name="help"  id="help" size="9" <?php if ($row['help']){ echo 'checked'; }?>  disabled="disabled" />
				машина без шашечек
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="smoking"  id="smoking" size="9" <?php if ($row['smoking']){ echo 'checked'; }?>  disabled="disabled" />
				в машине курить		
			</td>
			<td>
				<input type="checkbox"  name="curier"  id="curier" size="9" <?php if ($row['curier']){ echo 'checked'; }?>  disabled="disabled" />
				услуга курьера
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="inomarka"  id="inomarka" size="9" <?php if ($row['inomarka']){ echo 'checked'; }?>  disabled="disabled" />
				только иномарка
			</td>
			<td>
				<input type="checkbox"  name="trezv_driver"  id="trezv_driver" size="9" <?php if ($row['trezv_driver']){ echo 'checked'; }?>  disabled="disabled" />
				услуга «Трезвый Водитель»
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="animal"  id="animal" size="9" <?php if ($row['animal']){ echo 'checked'; }?>  disabled="disabled" />
				перевозка животного
			</td>
			<td>
				<input type="checkbox"  name="clear_car"  id="clear_car" size="9" <?php if ($row['clear_car']){ echo 'checked'; }?>  disabled="disabled" />
				чистая машина
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="luggage"  id="luggage" size="9" <?php if ($row['luggage']){ echo 'checked'; }?>  disabled="disabled" />
				крупный багаж в салон
			</td>
			<td>
				<input type="checkbox"  name="no_shashki"  id="no_shashki" size="9" <?php if ($row['no_shashki']){ echo 'checked'; }?>  disabled="disabled" />
				машина без шашечек
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="child_armchair_do_15"  id="child_armchair_do_15" size="9" <?php if ($row['child_armchair_do_15']){ echo 'checked'; }?>  disabled="disabled" />
				детское кресло до 15 кг
			</td>
			<td>
				<input type="checkbox"  name="skin_salon"  id="skin_salon" size="9" <?php if ($row['skin_salon']){ echo 'checked'; }?>  disabled="disabled" />
				кожаный салон
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="child_armchair_bolee_15"  id="child_armchair_bolee_15" size="9" <?php if ($row['child_armchair_bolee_15']){ echo 'checked'; }?>  disabled="disabled" />
				детское кресло свыше 15 кг
			</td>
			<td>
				<input type="checkbox"  name="transfert_table"  id="transfert_table" size="9" <?php if ($row['transfert_table']){ echo 'checked'; }?>  disabled="disabled" />
				трансферт с табличкой
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="condit"  id="condit" size="9" <?php if ($row['condit']){ echo 'checked'; }?>  disabled="disabled" />
				кондиционер
			</td>
			<td>
				<input type="checkbox"  name="kvit"  id="kvit" size="9" <?php if ($row['kvit']){ echo 'checked'; }?>  disabled="disabled" />
				квитанция</td>
		</tr>								
   </table>    
    <br>
	<table border="1">
		<tr>
		  <td align="left">
				Водитель и машина
				<select name="driver_set" id="driver_set" onchange="DriverSetCheck()">
					<option value="0">не выбрано</option>
<?php
	   $drv_id = mysql_result($res_order, 0, 'driver_id');
	   for ($i=0; $i<mysql_num_rows($res_set); $i++){
	   		$selected = ''; 
	   		if ($drv_id==mysql_result($res_set, $i, 7)){
	   			$selected =' selected '; 
			} 
			echo '<option value="'.mysql_result($res_set, $i, 0).'"  '.$selected.'>'.
					DB2Web(mysql_result($res_set, $i, 5)).' '.DB2Web(mysql_result($res_set, $i, 2)).' '.DB2Web(mysql_result($res_set, $i, 4)).' '.
					'</option>';
		}   ?>  
				</select>
<?php	//echo 'drv_id='.$drv_id.' 0='.mysql_result($res_set, 0, 7).' 1='.mysql_result($res_set, 1, 7) ?>
			</td>
			<td >
					<a onclick="Send_SMS('<?php echo DB2Web(mysql_result($res_order, $i_, 0))?>','<?php echo  $client_phone_id_?>', 'Test','VTSystemRu' ); return false;">
						<span id="send_sms_button" class="button">Отправить SMS</span>
					</a>
            </td>
			<td align="right" >
				<?php if (mysql_result($res_order, $i_, 33) == $company_id_)  {?>
					Начальная ставка обмена <select name="rate_na_torgi" id="rate_na_torgi"><?php echo printRates() ?>%</select>
					<a onclick="na_torgi(<?php echo DB2Web(mysql_result($res_order, $i_, 0))?>); return false;">
						<span id="put_to_site_button" class="button">Передать на площадку</span>
					</a>
				<?php }?>
			</td>
		</tr>	
    </table>
    <br>
	<table border="0">
		<tr>
			<td>
<?php $order_status = mysql_result($res_order, 0, 'order_status'); ?>			
				<select name="status_check" id="status_check">
					<option value="0" <?php echo ($order_status==0)?' selected ' :'' ?> >не выбрано</option>
					<option value="1" <?php echo ($order_status==1)?' selected ':'' ?>>назначен водитель</option>
					<option value="2" <?php echo ($order_status==2)?' selected ':'' ?>>водитель подтвердил заказ</option>
					<option value="3" <?php echo ($order_status==3)?' selected ':'' ?>>автомобиль подан</option>
					</option>
				</select>
			</td>
			<td>
				<a onclick="SetDriverCar(<?php echo $_GET['order_id']?>); return false;">
					<span id="driver_set_button" class="button">Сохранить изменения</span>
				</a>
			</td>
			<td>
				<?php if (mysql_result($res_order, $i_, 33) != $company_id_)  {?>
					<a onclick="Cancel_Order(<?php echo DB2Web(mysql_result($res_order, $i_, 0))?>); return false;">
						<span id="cancel_order_button" class="button">Отказаться от заказа</span>
					</a>
				<?php }?>
			</td>
			<td>
				<a onclick="closeOrder(<?php echo $_GET['order_id']?>); return false;">
					<span id="closed_order_button" class="button">Закрыть заказ</span>
				</a>
			</td>
		</tr>								
	</table>
