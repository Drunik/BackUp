<script type="text/javascript">

var inputs_new='';
function setPhone() {
    var inputs = document.getElementById('driver_phone').value;
	var l = inputs.length;
	if (inputs_new.length < inputs.length) {
		if (l == 3) {
			document.getElementById('driver_phone').value = inputs + ')';
		}
		if (l == 7) {
			document.getElementById('driver_phone').value = inputs + '-';
		}
		if (l == 10) {
			document.getElementById('driver_phone').value = inputs + '-';
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
    include('tools.php');
    include_once('db_ini.php');
    $company_id_ = $_GET['company_id'];
    $res_drivers = mysql_query(' SELECT driver_id, driver_name, driver_phone FROM drivers WHERE drivers.company_id = '.$company_id_);
   
?>	   
<?php      echo 'Всего водителей: '.mysql_num_rows($res_drivers);?>
   <table class="show_tables" >
	   		<tr class="componentheading">
				<th>ФИО</th>
				<th>Телефон</th>
				<th></th>
			</tr>
			<?php   for ($i_=0; $i_<mysql_num_rows($res_drivers); $i_++){   ?>
      		<tr>
				<td align="center"><?php echo DB2Web(mysql_result($res_drivers, $i_,1))?></td>
				<td align="center"><?php echo PrepPhone(DB2Web(mysql_result($res_drivers, $i_,2)))?></td>
                <td align="center">
                 	<a onclick="DeleteDriver(<?php echo DB2Web(mysql_result($res_drivers, $i_,0))?>)">
                      	<span id="fine_set_button" class="button">Удалить</span>
                    </a>
                </td>
			</tr>
<?php	}  ?>
		<tr class="slim">
		    <th colspan="3">Добавить нового водителя:</th>
		</tr>		    
		<tr>
			<td>						
			    <input type="text" size="50" name="driver_name" id="driver_name" placeholder="Фамилия Имя Отчество"/> 		
			</td>
			<td>			
			    8(<input  name="phone" type="text"  name="driver_phone"  id="driver_phone" onkeydown="setPhone()" value="" maxlength="13" onblur="check_black_list(); return false;" placeholder="Телефон"/>            
			</td>
			<td>
				<a onclick="AddDriver()">
					<span id="fine_set_button" class="button">Добавить</span>
				</a>
			</td>
		</tr>


   </table>