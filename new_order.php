<script type="text/javascript">
var inputs_new='';
function setPhone() {
    var inputs = document.getElementById('phone').value;
	var l = inputs.length;
	if (inputs_new.length < inputs.length) {
		if (l == 3) {
			document.getElementById('phone').value = inputs + ')';
		}
		if (l == 7) {
			document.getElementById('phone').value = inputs + '-';
		}
		if (l == 10) {
			document.getElementById('phone').value = inputs + '-';
		}
	}
    inputs_new = inputs;
}
</script>
<?php 
include_once('db_ini.php');
function DB2Web( $text_){
     $out_="UTF-8";
	 $in_="Windows-1251";
     //return iconv($in_,$out_,stripslashes($text_));
	 return stripslashes($text_);
}
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
function printClasses($class_id, $db){
   $res_classs = mysql_query( ' SELECT * FROM car_classes ORDER BY class_id ');
   $txt='';
   for ($i_=0; $i_<mysql_num_rows($res_classs); $i_++){
	   $selected = ''; 
	   if (mysql_result($res_classs, $i_,0)==$class_id){
	   		$selected =' selected '; 
		}  
       $txt.= '<option value="'.mysql_result($res_classs, $i_,0).'"'.  $selected.' '.$dis.'>'.DB2Web(mysql_result($res_classs, $i_,1)).'</option>'; 
   }
   return 	$txt;
}
?>
	<table class="show_tables">
		<tr>
			<th>
				Информация о заказчике
			</th>
			<td>
  	                <input type="checkbox" id="no_cash" name="no_cash" />Безналичный расчет
			</td>
		</tr>
		<tr>
			<th>
				Телефон клиента *
			</th>
			<td>
			    8(<input  name="phone" type="text"   id="phone" onkeydown="setPhone()" value="" maxlength="13" onblur="check_black_list(); return false;"/>
					<div id="black_list_div" name="black_list_div"></div>
			</td>
		</tr>
		<tr>
			<th>
				Имя клиента
			</th>
			<td>
				<input type="text" name="client_name" id="client_name" size="35" value=""/>
			</td>
		</tr>
		<tr>
			<th>
				Доп. информация
			</th>
			<td>
				<input type="text" name="comment" id="comment" size="35" value=""/>
			</td>
		</tr>
		<tr class="componentheading">
			<th>
				Требования к авто	
			</td>
			<th>
				Дополнительные требования				
			</th>
		</tr>
		<tr>
			<td>
				<input type="checkbox"  name="no_smoking"  id="no_smoking" size="9"/>
				<label for="no_smoking">в машине не курить</label>
			</td>
			<td>
				<input type="checkbox"  name="help"  id="help" size="9"/>
				<label for="help">машина без шашечек</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="smoking"  id="smoking" size="9"/>
				<label for="smoking">в машине курить</label>		
			</td>
			<td>
				<input type="checkbox"  name="curier"  id="curier" size="9"/>
				<label for="curier">услуга курьера</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="inomarka"  id="inomarka" size="9"/>
				<label for="inomarka">только иномарка</label>
			</td>
			<td>
				<input type="checkbox"  name="trezv_driver"  id="trezv_driver" size="9"/>
				<label for="trezv_driver">услуга «Трезвый Водитель»</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="animal"  id="animal" size="9"/>
				<label for="animal">перевозка животного</label>
			</td>
			<td>
				<input type="checkbox"  name="clear_car"  id="clear_car" size="9"/>
				<label for="clear_car">чистая машина</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="luggage"  id="luggage" size="9"/>
				<label for="luggage">крупный багаж в салон</label>
			</td>
			<td>
				<input type="checkbox"  name="no_shashki"  id="no_shashki" size="9"/>
				<label for="no_shashki">машина без шашечек</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="child_armchair_do_15"  id="child_armchair_do_15" size="9"/>
				<label for="child_armchair_do_15">детское кресло до 15 кг</label>
			</td>
			<td>
				<input type="checkbox"  name="skin_salon"  id="skin_salon" size="9"/>
				<label for="skin_salon">кожаный салон</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="child_armchair_bolee_15"  id="child_armchair_bolee_15" size="9"/>
				<label for="child_armchair_bolee_15">детское кресло свыше 15 кг</label>
			</td>
			<td>
				<input type="checkbox"  name="transfert_table"  id="transfert_table" size="9"/>
				<label for="transfert_table">трансферт с табличкой</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="condit"  id="condit" size="9"/>
				<label for="condit">кондиционер</label>
			</td>
			<td>
				<input type="checkbox"  name="kvit"  id="kvit" size="9"/>
				<label for="kvit">квитанция</label>
				<input type="hidden" id="order_type" name="order_type" value="order_type" value="1" />
			</td>
		</tr>								
		<tr>
			<td colspan="2">
				<table class="table_noborder" width="100%">
					<tr>
						<td style="text-align: right;">
							Начальная ставка обмена <select name="rate" id="rate"><?php echo printRates() ?>%</select>
						</td>	
						<td>	
							<input class="button" type="submit" name="submit" id="submit2" onclick="submit_form(2);" size="9" value="Передать на площадку"/>
						</td>
					</tr>
					<tr><td style="text-align: right;">
							<input class="button" type="submit" name="submit" id="submit1" onclick="submit_form(1);"  size="9" value="Оформить заказ"/>
					</td><td>
							<input class="button" type="reset" name="submit" id="clear_" size="9" value="Очистить форму"  onclick="clear_form();"/>
					</td></tr></table>
			</td>
		</tr>
	</table>