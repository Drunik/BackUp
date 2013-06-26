<script type="text/javascript">

var inputs_new='';
function setPhone() {
    var inputs = document.getElementById('client_phone').value;
	var l = inputs.length;
	if (inputs_new.length < inputs.length) {
		if (l == 3) {
			document.getElementById('client_phone').value = inputs + ')';
		}
		if (l == 7) {
			document.getElementById('client_phone').value = inputs + '-';
		}
		if (l == 10) {
			document.getElementById('client_phone').value = inputs + '-';
		}
	}
    inputs_new = inputs;
}

</script>
<?php 
function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
     //return iconv($in_,$out_,stripslashes($text_));
	 return stripslashes($text_);
}
session_start();
   include_once('db_ini.php');
   $company_id_ = $_GET['company_id'];
   $res_client_list = mysql_query(' SELECT client_list.id 	as client_id
							    , client_list.phone 		as client_phone
							    , client_list.description		as client_description
							    , client_list.discount		as client_discount
							    , client_list.no_cash 		as client_no_cash'.
	   							' FROM client_list '.
	   							' WHERE client_list.company_id = '.$company_id_) or die(mysql_error());

//     $line = mysql_fetch_assoc($res_client_list);
								
   
?>	   
<?php      echo 'Всего клиентов: '.mysql_num_rows($res_client_list);?>
   <table id="client_list_table" class="show_tables">
	   		<tr  class="componentheading">
				<th>Телефон</th>
				<th>Описание</th>
				<th>Скидка</th>
				<th>Безнал</th>
			</tr>
			<?php
//			for ($i_=0; $i_<mysql_num_rows($res_client_list	); $i_++){   
			while ($line = mysql_fetch_assoc($res_client_list)){
			?>
      		<tr>
				<td><?php echo DB2Web($line['client_phone'])?></td>
				<td><?php echo DB2Web($line['client_description'])?></td>
				<td><?php echo DB2Web($line['client_discount'])?></td>
				<td><input type="checkbox"  name="client_no_cash"  id="client_no_cash" size="9" <?php if ($line['client_no_cash']){ echo 'checked'; }?>  disabled="disabled"/></td>
                    <td class="">
                    	<a onclick="DeleteClient(<?php echo DB2Web($line['client_id'])?>)">
                        	<span id="delete_clien_button" class="button">Удалить</span>
                        </a>
                    </td>
			</tr>
			<?php	}  ?>
   </table>
   
   Добавить нового клиента
<br>   
   
   
	<table>
		<tr>
			<td>8(<input  name="phone" type="text"  name="client_phone"  id="client_phone" onkeydown="setPhone()" value="" maxlength="13" ; return false; placeholder="Телефон"/></td>
			<td><input type="text" size="30" name="client_description" id="client_description" placeholder="Описание"/><td>						
			<td><input type="text" size="30" name="client_discount" id="client_description" placeholder="Скидка"/><td>						
  			<td>Безнал <input type="checkbox"  name="client_no_cash"  id="client_no_cash" size="9" /></td>
			<td><a onclick="AddClient()"><span id="fine_set_button" class="button">Добавить</span></a></td>
		</tr>						
	</table>
