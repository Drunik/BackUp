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
   
     $res_set_tarif  = mysql_query('SELECT car_classes.class_name 		AS class_name_,
							      tariff.Tariff_Min_Summa		AS min_sum_,
							      tariff.Tariff_Min_Km			AS min_km_,
							      tariff.Tariff_Price_Km_Day	AS km_day_,
							      tariff.Tariff_Price_Km_Night	AS km_night_
						   FROM tariff'.
						   ' INNER JOIN car_classes ON car_classes.class_id = tariff.Tariff_Type'.
						   ' WHERE company_id = '.$company_id_.
						   ' ORDER BY  car_classes.class_id');
  
     $res_set_time  = mysql_query('SELECT	 tarif_time_periods.id 				AS id_,
							    tarif_time_periods.name 			AS name_time_,
						            tarif_time_periods.time_from_hours		AS time_from_hours_,
							    tarif_time_periods.time_from_min		AS time_from_min_,
						            tarif_time_periods.time_to_hours		AS time_to_hours_,
							    tarif_time_periods.time_to_min		AS time_to_min_,
							    tarif_time_periods.base_price			AS base_price_,
							    tarif_time_periods.distance_1			AS distance_1_,
							    tarif_time_periods.distance_2			AS distance_2_							    
						FROM tarif_time_periods'.
					        ' WHERE company_id = '.$company_id_.
						' ORDER BY time_from_hours') or die(mysql_error());
					  
     $res_set_classes  = mysql_query('SELECT	car_classes.class_id 				AS class_id_,
									car_classes.class_name 			AS class_name_
									   FROM car_classes'.
									   ' ORDER BY car_classes.class_id') or die(mysql_error());
     
//   $res_set_classes = mysql_query(' SELECT class_name FROM car_classes ORDER BY  class_id ');
					  
?>
<script>
        $(document).ready(function(){
	       $('#periods li:first').addClass('active');
	       $('div.show_period:first').show();
	  
		$("#periods li a").click(function () {
			$("#periods li").removeClass("active");
			$(this).parent("li").addClass("active"); //добавить класс "active" к выбраной вкладке
			$('.show_period').hide();
			var activeTab = '#' + $(this).attr("id") + '_cont';
			$(activeTab).show();
			return false;
		});	
        });	
	
</script>
     <ul id="periods" class="tabs">
 <?php   while ($line = mysql_fetch_assoc($res_set_time)){?>
 	<li><a href="#"	 	id="<?php echo DB2Web($line['id_'])?>"><?php echo DB2Web($line['name_time_'])?></a></li>
<?php	}
mysql_data_seek($res_set_time, 0);?>
     </ul>
     
 <?php   while ($line = mysql_fetch_assoc($res_set_time)){?>
 	<div id="<?php echo DB2Web($line['id_'])?>_cont" class="show_period" style="display: none;">
	  <table class="hover show_tables_nw">
	       <tr>
		    <th>Начало периода</th>
		    <td><?php if ($line['time_from_hours_'] < 10) echo 0; echo DB2Web($line['time_from_hours_'])?>:<?php if ($line['time_from_min_'] < 10) echo 0; echo DB2Web($line['time_from_min_'])?></td>
		    <th>Расстояние 1</th>
		    <td><?php echo DB2Web($line['distance_1_'])?> км.</td>
		    
		    <th rowspan="2">Базовая цена</th>
		    <td rowspan="2"><?php echo DB2Web($line['base_price_'])?> руб./км.</td>
	       </tr>
	       <tr>    
		    <th>Конец периода</th>
		    <td><?php if ($line['time_to_hours_'] < 10) echo 0; echo DB2Web($line['time_to_hours_'])?>:<?php if ($line['time_to_min_'] < 10) echo 0; echo DB2Web($line['time_to_min_'])?></td>
		    <th>Расстояние 2</th>
		    <td><?php echo DB2Web($line['distance_2_'])?> км.</td>
	       </tr>
	  </table>
	</div>  
<?php	}?>

   
     
Тарифы
<br/>
   <table class="show_tables">
   
	   		<tr  class="componentheading">
				<th rowspan="2">Тип Авто</th>
				<th rowspan="2">Мин. Сумма Заказа</th>
				<th rowspan="2">Мин. Кол-во Км</th>
			        <th colspan="4">Стоимость Км</th>
			</tr>
			<tr>				
				<th>Утро</th>
				<th>День</th>
				<th>Вечер</th>
				<th>Ночь</th>
			</tr>
<?php   while ($line = mysql_fetch_array($res_set_tarif, MYSQL_ASSOC)){?>
      			<tr>
						<td><?php echo DB2Web($line['class_name_'])?></td>
						<td><input type="text" size="10" name="min_sum" id="min_sum" value="<?php echo DB2Web($line['min_sum_'])?>" /></td>
						<td><input type="text" size="10" name="min_km" id="min_km" value="<?php echo DB2Web($line['min_km_'])?>" /></td>
						<td><input type="text" size="10" name="km_day" id="km_day" value="<?php echo DB2Web($line['km_day_'])?>" /></td>
						<td><input type="text" size="10" name="km_day" id="km_day" value="<?php echo DB2Web($line['km_day_'])?>" /></td>
						<td><input type="text" size="10" name="km_night" id="km_day" value="<?php echo DB2Web($line['km_night_'])?>" /></td>
						<td><input type="text" size="10" name="km_night" id="km_day" value="<?php echo DB2Web($line['km_night_'])?>" /></td>
				</tr>

<?php	}?>
   </table>
   
   <table class="show_tables">
     <tr  class="componentheading">
	  <th rowspan="2">Тип Авто</th>
	  <th colspan="2">до dist1</th>
	  <th colspan="2">от dist1 до dist2</th>
	  <th colspan="2">от dist2</th>
     </tr>
     <tr class="slim componentheading">     
	  <th>Коэфф.</th><th>Стоим. км</th>
	  <th>Коэфф.</th><th>Стоим. км</th>
	  <th>Коэфф.</th><th>Стоим. км</th>
     </tr>
     <tr>
	  <td>Тип Авто</td>
	  <td><input type="text" size="5" id="km_day" value="777" /></td><td><input type="text" size="5" id="km_day" value="888" /></td>
	  <td><input type="text" size="5" id="km_day" value="777" /></td><td><input type="text" size="5" id="km_day" value="777" /></td>
	  <td><input type="text" size="5" id="km_day" value="777" /></td><td><input type="text" size="5" id="km_day" value="777" /></td>
     </tr>			
     
   </table>   
   
   