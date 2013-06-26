<script type="text/javascript">
     function TestSMS() {
	  inputs = document.getElementById('client_order_test').value;
	  document.getElementById('driver_confirm_order_sms_text_test').value = inputs;
     }
</script>


<?php

/*     <?php echo ShowTestSMS('designated_driver')?>
     <?php echo ShowTestSMS('driver_confirm_order')?>
     <?php echo ShowTestSMS('car_filed')?>
     <?php echo ShowTestSMS('all_cars')?>
*/


     function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
     //return iconv($in_,$out_,stripslashes($text_));
	 return stripslashes($text_);
     }
     session_start();
     include_once('db_ini.php');
     include('tools.php');
     $company_id_ = $_GET['company_id'];
     
     function ShowTestSMS( $type_,$order_id_){
	  $company_id_ 	= $_GET['company_id'];
	  return ShowSMS($type_, $order_id_, $company_id_, 'test');
     }
     
     
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
			   ' WHERE companies.company_id = '.$company_id_) or die(mysql_error());
     
     $row = mysql_fetch_assoc($res_company);
?>

   <table id="company_english_name" class="show_tables">
           		<tr>
			      <th>Имя отправителя</th>
			      <td colspan="2"><input type="text" name="company_english_name"  id="company_english_name" size="50" value="<?php echo DB2Web($row['company_english_name'])?>"   readonly="readonly"/></td>
			</tr>
           		<tr>
			 <th>Номер заказа для проверки</th>
			 <td>
			      <input type="text" size="30" name="client_order_test" id="client_order_test" placeholder="Номер заказа"/>
	  			<a onclick=""; return false;">
	  				<span id="test_sms_button" class="button">Проверить</span>
          			</a>
			 </td>
			</tr>
   </table>
   <br>
   <table id="company_sms_settings" class="show_tables">
	   		<tr  class="componentheading">
				<th>Опция</th>
				<th>Статус</th>
				<th>Текст SMS</th>
				<th>Проверка</th>
			</tr>
           		<tr>
			      <th>Назначен водитель</th>
			      <td><input type="checkbox"  name="designated_driver"  id="designated_driver" size="9" <?php if ($row['designated_driver']){ echo 'checked'; }?>/></td>
			      <td><textarea rows="3" cols="30" name="designated_driver_sms_text"><?php echo DB2Web($row['designated_driver_sms_text'])?></textarea></td>
			      <td><textarea rows="3" cols="30" id="designated_driver_sms_text_test" name="ddesignated_driver_sms_text_test"></textarea></td>
			      </td>
			</tr>
           		<tr>
			      <th>Водитель подтвердил заказ</th>
			      <td><input type="checkbox"  name="driver_confirm_order"  id="driver_confirm_order" size="9" <?php if ($row['driver_confirm_order']){ echo 'checked'; }?>/></td>
			      <td><textarea rows="3" cols="30" id="driver_confirm_order_sms_text" name="driver_confirm_order_sms_text"><?php echo DB2Web($row['driver_confirm_order_sms_text'])?></textarea></td>
			      <td><textarea rows="3" cols="30" id="driver_confirm_order_sms_text_test" name="driver_confirm_order_sms_text_test"></textarea></td>
			</tr>
           		<tr>
			      <th>Автомобиль подан</th>
			      <td><input type="checkbox"  name="car_filed"  id="car_filed" size="9" <?php if ($row['car_filed']){ echo 'checked'; }?>/></td>
			      <td><textarea rows="3" cols="30" name="car_filed_sms_text"><?php echo DB2Web($row['car_filed_sms_text'])?></textarea></td>
			      <td><textarea rows="3" cols="30" name="car_filed_sms_text_test"></textarea></td>
			</tr>
           		<tr>
			      <th>Отправка SMS всем водителям на линии</th>
			      <td><input type="checkbox"  name="all_cars"  id="all_cars" size="9" <?php if ($row['all_cars']){ echo 'checked'; }?>/></td>
			      <td><textarea rows="3" cols="30" name="all_cars_sms_text"><?php echo DB2Web($row['all_cars_sms_text'])?></textarea></td>
			      <td><textarea rows="3" cols="30" name="all_cars_sms_text_test"></textarea></td>
			</tr>
   </table>
   <br>
   <table class="show_tables">
			<td>
				<a onclick="SaveSMSSettings(<?php echo $_GET['company_id']?>); return false;">
					<span id="company_save_button" class="button">Сохранить изменения</span>
				</a>
			</td>
   </table>
