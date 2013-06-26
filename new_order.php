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

// Меняем поле Стоимость в зависимости от выбора доп. услуг

    $(document).ready(function(){
	
	$("#new_order_table input[type=checkbox]").click(function(){
	    
	    var $all_price = parseInt($('#input_order_table #price').val());
	    var $cost = parseInt($(this).attr('cost'));
	    
	    if ($(this).is(':checked')) {
		$('#input_order_table #price').val($all_price+$cost)
	    }
	    else{
		$('#input_order_table #price').val($all_price-$cost)
	    }
	    calcDiscount();
	    if ($cost != 0)
		$('#input_order_table #price').css("background-color","#caeaf4");
	});
    
    });
    
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
   for ($i_=1; $i_<11; $i_++){
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
$company_id = $_GET['company_id'];

$res_price = mysql_query(' SELECT luggage_price 	as luggage_price
		, child_armchair_price 			as child_armchair_price
		, entry_price				as entry_price
		, vokzal_price				as vokzal_price
		, airport_price				as airport_price
		, transfert_table_price			as transfert_table_price
		, animals				as animals
		FROM companies
		WHERE companies.company_id = '.$company_id) or die(mysql_error());

$price = mysql_fetch_assoc($res_price);
?>
	<table id="new_order_table" class="show_tables">
		<tr>
			<th>
				Информация о заказчике
			</th>
			<td>
  	                <input type="checkbox" id="client_no_cash" name="no_cash" />Безналичный расчет &nbsp;&nbsp;&nbsp;
					<input id="company_name_beznal" name="company_name_beznal" type="text" size="25" />
			</td>
		</tr>
		<tr>
			<th>
				Телефон клиента *
			</th>
			<td>
			    8(<input  name="phone" type="text"   id="client_phone" onkeydown="setPhone();" value="" maxlength="13" onblur="check_black_list(); return false;"/>
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
				<input type="text" name="comment" id="client_comment" size="35" value=""/>
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
				<input type="checkbox"  name="no_smoking"  id="no_smoking" size="9" cost="0"/>
				<label for="no_smoking">в машине не курить</label>
			</td>
			<td>
				<input type="checkbox"  name="help"  id="help" size="9" cost="0"/>
				<label for="help">машина без шашечек</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="smoking"  id="smoking" size="9" cost="0"/>
				<label for="smoking">в машине курить</label>		
			</td>
			<td>
				<input type="checkbox"  name="curier"  id="curier" size="9" cost="0"/>
				<label for="curier">услуга курьера</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="inomarka"  id="inomarka" size="9" cost="0"/>
				<label for="inomarka">только иномарка</label>
			</td>
			<td>
				<input type="checkbox"  name="entry"  id="entry" size="9" cost="<? echo $price['entry_price'];?>"/>
				<label for="entry">заезд на предприятие</label>			    
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="animal"  id="animal" size="9" cost="0"/>
				<label for="animal">перевозка животного</label>
			</td>
			<td>
				<input type="checkbox"  name="clear_car"  id="clear_car" size="9" cost="0"/>
				<label for="clear_car">чистая машина</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="luggage"  id="luggage" size="9" cost="<? echo $price['luggage_price'];?>"/>
				<label for="luggage">крупный багаж в салон</label>
			</td>
			<td>
				<input type="checkbox"  name="no_shashki"  id="no_shashki" size="9" cost="0"/>
				<label for="no_shashki">машина без шашечек</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="child_armchair_do_15"  id="child_armchair_do_15" size="9" cost="<? echo $price['child_armchair_price'];?>"/>
				<label for="child_armchair_do_15">детское кресло до 15 кг</label>
			</td>
			<td>
				<input type="checkbox"  name="skin_salon"  id="skin_salon" size="9" cost="0"/>
				<label for="skin_salon">кожаный салон</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="child_armchair_bolee_15"  id="child_armchair_bolee_15" size="9" cost="<? echo $price['child_armchair_price'];?>"/>
				<label for="child_armchair_bolee_15">детское кресло свыше 15 кг</label>
			</td>
			<td>
				<input type="checkbox"  name="transfert_table"  id="transfert_table" size="9" cost="<? echo $price['transfert_table_price'];?>"/>
				<label for="transfert_table">трансферт с табличкой</label>
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="condit"  id="condit" size="9" cost="0"/>
				<label for="condit">кондиционер</label>
			</td>
			<td>
				<input type="checkbox"  name="kvit"  id="kvit" size="9" cost="0"/>
				<label for="kvit">квитанция</label>
				<input type="hidden" id="order_type" name="order_type" value="order_type" value="1" />
			</td>
		</tr>								
		<tr>
			<td>
				<input type="checkbox"  name="trezv_driver"  id="trezv_driver" size="9" cost="0"/>
				<label for="trezv_driver">услуга «Трезвый Водитель»</label>
			</td>
			<td>
				<input type="checkbox"  name="animals"  id="animals" size="9" cost="<? echo $price['animals'];?>"/>
				<label for="animals">животные</label>
			</td>
		</tr>								
		<tr>
			<td colspan="2">
				<table class="table_noborder" width="100%">
					<!--<tr>
					    
						<td style="text-align: right;">
							Начальная ставка обмена <select name="rate" id="rate"><?php echo printRates() ?>%</select>
						</td>	
						<td>	
							<input class="button" type="submit" name="submit" id="submit2" onclick="submit_form(2);" size="9" value="Передать на площадку"/>
						</td>
					    
					</tr>-->
					<tr><td style="text-align: right;">
							<input class="button" type="submit" name="submit" id="submit1" onclick="submit_form(1);"  size="9" value="Оформить заказ"/>
					</td><td>
							<input class="button" type="reset" name="submit" id="clear_" size="9" value="Очистить форму"  onclick="clear_form();"/>
					</td></tr></table>
			</td>
		</tr>
	</table>