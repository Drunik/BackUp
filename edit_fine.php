<?php 

	function DB2Web( $text_){
		$out_="UTF-8";
		$in_="Windows-1251";
		 return stripslashes($text_);
	}

	session_start();

   include_once('db_ini.php');
   
   $fine_id_    = $_GET['fine_id'];
   $company_id_  = $_GET['company_id'];
   

   $res_cur_fine = mysql_query(' SELECT fines_entry.id, fines_entry.datetime '.
   								' ,fines.description , fines.amount '.
								' ,company_from.company_id, company_from.company_name'.
								' ,company_to.company_id, company_to.company_name '.
								' ,fines_entry.comment_from, fines_entry.comment_from, fines_entry.order_id'.
   								' FROM fines_entry'.
   								' INNER JOIN companies company_from ON company_from.company_id = fines_entry.company_from_id'.
   								' INNER JOIN companies company_to   ON company_to.company_id = fines_entry.company_to_id'.
   								' INNER JOIN fines ON fines.id = fines_entry.fines_id'.
   								' WHERE fines_entry.id = '.$fine_id_
								);



   $res_cur_company = mysql_query('SELECT company_id, company_name FROM companies WHERE companies.company_id = '.$_GET['company_id']);
   
?>	   

Претензия № "<?php echo $fine_id_?>"
<br>
Дата: <?php echo DB2Web(mysql_result($res_cur_fine, 0,1))?> 
<br>
Предмет претензии: заказ № <?php echo DB2Web(mysql_result($res_cur_fine, 0,10))?> 
<br>
Описание претензии:
<br>
<textarea id="Fine_Description" name="Fine_Description" rows="3" cols="50" readonly="readonly">
<?php echo DB2Web(mysql_result($res_cur_fine, 0,2))?> 
</textarea>
<br>
Сумма: 
<?php echo DB2Web(mysql_result($res_cur_fine, 0,3))?> руб.
<br>
Истец :
<?php echo DB2Web(mysql_result($res_cur_fine, 0,5))?> 
<br>
<textarea id="Comment_From" name="Comment_From" rows="3" cols="50" readonly="readonly">
<?php echo DB2Web(mysql_result($res_cur_fine, 0,8))?> 
</textarea>
<br>
Ответчик :
<?php echo DB2Web(mysql_result($res_cur_fine, 0,7))?> 

<br>
<textarea id="Comment_To" name="Comment_To" rows="3" cols="50">
</textarea>
<br>

<a onclick="agree_fine(<?php echo $_GET['fine_id']?>)">
<span id="fine_set_button" class="button" style="width:130px" >Согласиться</span>
</a>
<br/>
<a onclick="disagree_fine(<?php echo $_GET['fine_id']?>)">
<span id="fine_set_button" class="button" style="width:130px" >Не согласиться</span>
</a>

