<script type="text/javascript">

var inputs_new='';
function setPhone() {
    var inputs = document.getElementById('dispetcher_phone').value;
	var l = inputs.length;
	if (inputs_new.length < inputs.length) {
		if (l == 3) {
			document.getElementById('dispetcher_phone').value = inputs + ')';
		}
		if (l == 7) {
			document.getElementById('dispetcher_phone').value = inputs + '-';
		}
		if (l == 10) {
			document.getElementById('dispetcher_phone').value = inputs + '-';
		}
	}
    inputs_new = inputs;
}

</script>
<?php
session_start();
   include_once('db_ini.php');
   $company_id_ = $_GET['company_id'];
   $user_group = 2; // диспетчеры
   
   $res_dispetchers =     mysql_query('SELECT
					 id
					,name
					,username
					,phone
				   FROM jos_users
				   WHERE user_group = '.$user_group.'
				   AND company_id = '.$company_id_);
?>	   
<?php      echo 'Всего Диспетчеров: '.mysql_num_rows($res_dispetchers);?>
   <table class="show_tables" >
     <tr class="componentheading">
	  <th>ФИО</th>
	  <th>Телефон</th>
	  <th></th>
     </tr>
<?php   while ($line = mysql_fetch_assoc($res_dispetchers)){   ?>
     <tr>
	  <td align="center"><?php echo $line['name']?></td>
	  <td align="center"><?php echo $line['phone']?></td>
	  <td align="center"><span id="del_dispetcher" class="button" onclick="del_dispetcher(<?echo $line['id']?>);">Удалить</span></td>
     </tr>
<?php	}  ?>
     <tr class="slim">
	  <th colspan="3">Добавить диспетчера:</th>
     </tr>		    
     <tr>
	     <td><input type="text" size="50" name="dispetcher_name" id="dispetcher_name" placeholder="Фамилия Имя Отчество" /></td>
	     <td>8(<input  name="phone" type="text"  name="dispetcher_phone"  id="dispetcher_phone" onkeydown="setPhone();" value="" maxlength="13" onblur="check_black_list(); return false;" placeholder="Телефон"/></td>
	     <td><span id="add_dispetcher" class="button" onclick="add_dispetcher()">Добавить</span></td>
     </tr>
   </table>