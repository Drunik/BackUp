<script type="text/javascript">
	var  full_fines = [];
	var  sum_fines  = [];

  function chek_option(item) {
    var str = "";
    $(item.children).each(function () {
      if(this.selected) str += $(this).val() + " ";
    });
	alert(item);
	alert();
	fine_set_id = document.getElementById('fine_set').value;
	document.getElementById('textarea1').value = full_fines[fine_set_id];
	document.getElementById('sum_area1').value = sum_fines[fine_set_id];
	}
 </script>

<?php 
function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
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
<?php   for($i=0; $i<mysql_num_rows($res_fines); $i++){ ?>
		full_fines[<?php echo $i?>] = <?php echo mysql_result($res_fines, $i, 2)?>;
		sum_fines[<?php echo $i?>] = <?php echo mysql_result($res_fines, $i, 3)?>;
<?php   }	?>	   

 
<table border="1" bgcolor="#FFFFFF">
	<tr>
		<td>
			Претензия № ...
			<br>
			Истец: 
			<?php echo DB2Web(mysql_result($res_cur_company, 0,1))?> (<?php echo DB2Web(mysql_result($res_cur_user, 0,1))?>)
			<br>
			Претензия:
				<select name="fine_set" id="fine_set" onchange="chek_option(this)">
					<option>не выбрано</option>
						<?php   for ($i=0; $i<mysql_num_rows($res_fines); $i++){
							echo '<option value="'.mysql_result($res_fines, $i, 0).'">'.
							DB2Web(mysql_result($res_fines, $i, 1)).
							' - '.
							DB2Web(mysql_result($res_fines, $i, 3)).
							' руб.'.
							'</option>';
							}   
						?>  
				</select>
			<br>
			Описание претензии: <?php echo mysql_num_rows($res_cur_fine)?>
			<br>
			<textarea id="textarea1" name="textarea1" rows="3" cols="50">
			</textarea>
			<br>
			<?php echo DB2Web(mysql_result($res_cur_fine, 0, 1))?>
			<br>
			Сумма претензии
			<textarea id="sum_area1" name="sum_area1" rows="1" cols="8">
			</textarea>
			<br>
			Предмет претензии: заказ № "<?php echo $order_id_?>"
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
			Описание события, повлекшее иницирование претензии:
				<input type="text" name="comment" id="comment" size="50" value=""/>
			<br>
				<a onclick="Add_Fine()">
					<span id="fine_set_button" class="button" style="width:130px" >Подать претензию</span>
				</a>
			<br>
		</td>
	</tr>
</table>

