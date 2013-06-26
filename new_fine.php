<?php 
function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
     //return iconv($in_,$out_,stripslashes($text_));
	 return stripslashes($text_);
}
   session_start();
   include_once('db_ini.php');
   $order_id_    = $_GET['order_id'];
   $user_id_     = $_GET['user_id'];
   $company_id_  = $_GET['company_id'];
   $res_fines    = mysql_query('SELECT id, name, description, amount  FROM fines ');
   $res_cur_user = mysql_query('SELECT id, name FROM jos_users WHERE jos_users.id = '.$_GET['user_id']);
   $res_cur_company = mysql_query('SELECT company_id, company_name FROM companies WHERE companies.company_id = '.$_GET['company_id']);
   $res_defendant = mysql_query('SELECT company_id, company_name FROM companies WHERE companies.company_id != '.$_GET['company_id']);
?>


<script type="text/javascript">




	
$(document).ready(function() { 
  	$('#fine_set').change(function() 
	{
		if ($(this).val() != 0){
		 $('#textarea1').val($('#fine_set option:selected').attr('alt'));
		 $('#fine_sum').text($('#fine_set option:selected').attr('sum'));
		 $('#fine_id').val($(this).val());
		}
		else{	
		 $('#textarea1').val('');
		 $('#fine_sum').text('0');
		}
	});
});  	
	
  </script>
Истец: 
<?php echo DB2Web(mysql_result($res_cur_company, 0,1))?> (<?php echo DB2Web(mysql_result($res_cur_user, 0,1))?>)
<br>
Ответчик
				<select name="defendant_set" id="defendant_set">
					<option onchange="GetCurFine" value="0">не выбрано</option>
<?php   for ($i=0; $i<mysql_num_rows($res_defendant); $i++){
				echo '<option value="'.mysql_result($res_defendant, $i, 0).'">'.
				DB2Web(mysql_result($res_defendant, $i, 1)).
				'</option>';
		}   ?>  
				</select>	
<br>
Предмет претензии: <span style="font-size: medium;">заказ №<?php echo $order_id_?></span>
<br>
Претензия:
				<select name="fine_set" id="fine_set">
					<option value="0">не выбрано</option>
						<?php
							while ($fine = mysql_fetch_array($res_fines, MYSQL_ASSOC)){
								echo '<option value="'.$fine['id'].'" '.
								'alt="'.$fine['description'].'" '.
								'sum="'.$fine['amount'].'">'.
								DB2Web(mb_substr($fine['description'], 0, 40, 'UTF-8')).
								'...'.
								'</option>';	
							}
						?>  
				</select>
<input id="fine_id" name="fine_id" type="hidden">				
<br>
Описание претензии:
<br>
<textarea id="textarea1" name="textarea1" rows="4" cols="50" readonly="readonly">
</textarea>
<br>
Сумма претензии: <span id="fine_sum" style="font-size: medium;">0</span> руб.
<br>
Описание события, повлекшее иницирование претензии:
<br>
<textarea name="comment" id="comment" rows="3" cols="50">
</textarea>

<br>
				<a onclick="AddFine(<?php echo $order_id_?>)">
					<span id="fine_set_button" class="button" style="width:130px" >Подать претензию</span>
				</a>
