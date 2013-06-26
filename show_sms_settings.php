<?php


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
     
     
     $res_company = mysql_query(' SELECT designated_driver 	as designated_driver
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
			   
	$max_id_res = mysql_query(" SELECT MAX(order_id) FROM taxi3_orders WHERE driver_id>0 AND company_id = ".$company_id_);		 
	if(mysql_num_rows($max_id_res)>0){
		 $max_order_id = mysql_result($max_id_res, 0, 0);
	}  
     
    $row = mysql_fetch_assoc($res_company);
?>
<script type="text/javascript">
     

     
   
$(document).ready(function(){
     $(".save_text").bind('input', function(){
	  $id = $(this).attr('id');
	  $text = $(this).val();

	  edit_sms($id, $text);
     });
     

     $("#company_sms_settings input[type=checkbox]").click(function(){
	  
	  $id = $(this).attr('id');
	  var $flag = 0;
	  if ($(this).is(':checked'))
	       $flag = 1;
	       
	  edit_sms($id, $flag);
     });
});   

</script>

   <table id="company_english_name" class="show_tables">
           		<tr>
			      <th>Имя отправителя</th>
			      <td colspan="2"><input type="text" name="company_english_name"  id="company_english_name" size="50" value="<?php echo DB2Web($row['company_english_name'])?>"   readonly="readonly"/></td>
			</tr>
           		<tr>
			 <th>Номер заказа для проверки</th>
			 <td>
			      <input type="text" size="30" name="client_order_test" id="client_order_test" placeholder="Номер заказа" value="<?php echo $max_order_id;?>"/>
	  			<a onclick="TestSMS();"><span id="test_sms_button" class="button">Проверить</span></a>
			 </td>
			</tr>
   </table>
   <br>
   <div id="sms_test_input_point"></div>
   <table id="company_sms_settings" class="show_tables">
	   		<tr  class="componentheading">
				<th>Опция</th>
				<th>Статус</th>
				<th>Текст SMS</th>
				<th>Проверка</th>
			</tr>
           		<tr>
			      <th>Назначен водитель</th>
			      <td><input id="designated_driver" type="checkbox" name="designated_driver" size="9" <?php if ($row['designated_driver'] == 1){ echo 'checked'; }?>/></td>
			      <td><textarea id="designated_driver_sms_text"class="save_text" rows="3" cols="30"><?php echo DB2Web($row['designated_driver_sms_text'])?></textarea></td>
			      <td><textarea rows="4" cols="30" id="designated_driver_sms_text_test" name="designated_driver_sms_text_test"></textarea></td>
			      </td>
			</tr>
           		<tr>
			      <th>Водитель подтвердил заказ</th>
			      <td><input id="driver_confirm_order" type="checkbox"  name="driver_confirm_order" size="9" <?php if ($row['driver_confirm_order'] == 1){ echo 'checked'; }?>/></td>
			      <td><textarea id="driver_confirm_order_sms_text" class="save_text" rows="3" cols="30" name="driver_confirm_order_sms_text"><?php echo DB2Web($row['driver_confirm_order_sms_text'])?></textarea></td>
			      <td><textarea rows="4" cols="30" id="driver_confirm_order_sms_text_test" name="driver_confirm_order_sms_text_test"></textarea></td>
			</tr>
           		<tr>
			      <th>Автомобиль подан</th>
			      <td><input id="car_filed" type="checkbox"  name="car_filed" size="9" <?php if ($row['car_filed'] == 1){ echo 'checked'; }?>/></td>
			      <td><textarea id="car_filed_sms_text"class="save_text" rows="3" cols="30" name="car_filed_sms_text"><?php echo DB2Web($row['car_filed_sms_text'])?></textarea></td>
			      <td><textarea rows="4" cols="30" name="car_filed_sms_text_test" id="car_filed_sms_text_test"></textarea></td>
			</tr>
           		<tr>
			      <th>Отправка SMS всем водителям на линии</th>
			      <td><input id="all_cars" type="checkbox"  name="all_cars" size="9" <?php if ($row['all_cars'] == 1){ echo 'checked'; }?>/></td>
			      <td><textarea id="all_cars_sms_text" class="save_text" rows="3" cols="30" name="all_cars_sms_text"><?php echo DB2Web($row['all_cars_sms_text'])?></textarea></td>
			      <td><textarea rows="4" cols="30" name="all_cars_sms_text_test" id="all_cars_sms_text_test"></textarea></td>
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
