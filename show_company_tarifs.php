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
/*   
     $res_set_tarif  = mysql_query('SELECT car_classes.class_name 		AS class_name_,
					     tariff.Tariff_Min_Summa		AS min_sum_,
					     tariff.Tariff_Min_Km		AS min_km_,
					     tariff.Tariff_Price_Km_Day		AS km_day_,
					     tariff.Tariff_Price_Km_Night	AS km_night_
					FROM tariff'.
					' INNER JOIN car_classes ON car_classes.class_id = tariff.Tariff_Type'.
					' WHERE company_id = '.$company_id_.
					' ORDER BY  car_classes.class_id');
*/  
     $res_set_time  = mysql_query('SELECT
					tarif_time_periods.id 			AS id_,
					tarif_time_periods.name 		AS name_time_,
					tarif_time_periods.time_from_hours	AS time_from_hours_,
					tarif_time_periods.time_from_min	AS time_from_min_,
					tarif_time_periods.time_to_hours	AS time_to_hours_,
					tarif_time_periods.time_to_min		AS time_to_min_,
					tarif_time_periods.distance_1		AS distance_1_,
					tarif_time_periods.distance_2		AS distance_2_
				   FROM
					tarif_time_periods
				   WHERE
					tarif_time_periods.company_id = '.$company_id_.'
				   ORDER BY
					tarif_time_periods.time_from_hours') or die(mysql_error());
					  
     $res_set_classes  = mysql_query('SELECT
					      car_classes.class_id	AS class_id_
					     ,car_classes.class_name	AS class_name_
					FROM
					      car_classes
					ORDER BY
					      car_classes.class_id');
     
     $res_car_classes  = mysql_query('SELECT
					     car_classes.class_id 		AS class_id_
					    ,car_classes.class_name 		AS class_name_
					FROM
					     companies_tarifs 
					INNER JOIN
					     car_classes ON car_classes.class_id = companies_tarifs.car_class_id 
					WHERE
					     companies_tarifs.company_id =  '.$company_id_.'
					ORDER BY
					     car_classes.class_id');     
     
     
     
//   $res_set_classes = mysql_query(' SELECT class_name FROM car_classes ORDER BY  class_id ');
					  
?>
<script>
        $(document).ready(function(){
	  // При нажатии на кнопку Тарифы - откроется первый период
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
		
	  $("#extended_tarifs input[type=text]").each(function(){
	       if ($(this).val() == '') $(this).val('0');
	  });
		
		
	  // При изменении полей коэфф. и сумма, значения меняются динамически и пропорционально	  
	  $("#extended_tarifs input[type=text]").bind('input', function(){
	       $(this).css("background-color","#fff");
	       var  $group = $(this).attr("group"),
		    $id = $(this).attr("id"),
		    $class = $(this).attr("class"),
		    $base_price = $(this).closest('tr').attr('base_price'),
		    $tr_id = $(this).closest('tr').attr("id"),
		    $period_id = $(this).closest('div').attr('period_id'),
		    $car_class_id = $(this).closest('tr').attr("car_class"),
		    $div_tr = '#' + $(this).closest('div').attr('id') + ' #' + $tr_id;
		    $div_table_tr = '#' + $(this).closest('div').attr('id') + ' #' + $tr_id+ ' #' + $tr_id;
		    
	       // Если введенный символ не число, то окрашиваем поле в красный цвет
	       if (!/^[0-9\.]+$/.test($(this).val())) {
		    $(this).css("background-color","#FFE4E1");	    
	       }
	       else{
		    $(this).css("background-color","#caeaf4");
	       // Если ок, то перемножаем коэффициент
		    if ($class == "ratio") {
			 $ratio = $(this).val();
			 $($div_tr+' input[group='+$group+'].price').val(Math.round($base_price*$ratio*100)/100);
			 $($div_tr+' input[group='+$group+'].price').css("background-color","#fff");
		    }
     
		    if ($class == "price") {
			 $price = $(this).val();
			 $($div_tr+' input[group='+$group+'].ratio').val(Math.round($base_price/$price*100)/100);
			 $($div_tr+' input[group='+$group+'].ratio').css("background-color","#fff");
		    }	       
	       }
	       
	       // Еще раз проходим по всем полям, проверяя везде ли цифры
	       var $n = 0; 
	       $($div_tr + " input[type=text]").each(function(){
		    if ((!/^[0-9\.]+$/.test($(this).val())) || ($(this).val() == 0)){
			 $n++;
			 $(this).css("background-color","#FFE4E1");
		    }
 	       });
	       	
	       if ($n == 0) {
		   edit_ext_tarif($period_id, $div_table_tr, $car_class_id, $id);
	       }
	      // alert($div_table_tr);
	  });	  
        });	
	
</script>
     <ul id="periods" class="tabs">
 <?php   while ($time_period = mysql_fetch_assoc($res_set_time)){?>
 	<li><a href="#"	id="<?php echo DB2Web($time_period['id_'])?>"><?php echo DB2Web($time_period['name_time_'])?></a></li>
<?php	}
mysql_data_seek($res_set_time, 0);?>
     </ul>
     
 <?php   while ($time_period = mysql_fetch_assoc($res_set_time)){?>
 	<div id="<?php echo DB2Web($time_period['id_'])?>_cont" class="show_period" period_id="<?php echo $time_period['id_']?>" style="display: none;">
	  <table class="show_tables_nw">
	       <tr>
		    <th>Начало периода</th>
		    <td><?php if ($time_period['time_from_hours_'] < 10) echo 0; echo DB2Web($time_period['time_from_hours_'])?>:<?php if ($time_period['time_from_min_'] < 10) echo 0; echo DB2Web($time_period['time_from_min_'])?></td>
		    <th>Расстояние 1</th>
		    <td><?php echo DB2Web($time_period['distance_1_'])?> км.</td>
	       </tr>
	       <tr>    
		    <th>Конец периода</th>
		    <td><?php if ($time_period['time_to_hours_'] < 10) echo 0; echo DB2Web($time_period['time_to_hours_'])?>:<?php if ($time_period['time_to_min_'] < 10) echo 0; echo DB2Web($time_period['time_to_min_'])?></td>
		    <th>Расстояние 2</th>
		    <td><?php echo DB2Web($time_period['distance_2_'])?> км.</td>
	       </tr>
	  </table>
<br/>	  
  
   <table id="extended_tarifs" class="show_tables">
     <tr  class="componentheading">
	  <th rowspan="2">Тип Авто</th>
	  <th rowspan="2">Базовая цена</th>
	  <th colspan="2">до <?php echo DB2Web($time_period['distance_1_'])?> км.</th>
	  <th colspan="2">от <?php echo DB2Web($time_period['distance_1_'])?> до <?php echo DB2Web($time_period['distance_2_'])?> км.</th>
	  <th colspan="2">от <?php echo DB2Web($time_period['distance_2_'])?> км.</th>
     </tr>
     <tr class="slim componentheading">     
	  <th>Коэфф.</th><th>Стоим. км</th>
	  <th>Коэфф.</th><th>Стоим. км</th>
	  <th>Коэфф.</th><th>Стоим. км</th>
     </tr>
<?php   while ($car_class = mysql_fetch_assoc($res_car_classes)){
     
     $res_tarifs  = mysql_query('SELECT
					 companies_tarifs.base_price		AS base_price_
					,companies_ext_tarifs.ratio_1		AS ratio_1_
					,companies_ext_tarifs.ratio_2		AS ratio_2_
					,companies_ext_tarifs.ratio_3		AS ratio_3_
					,companies_ext_tarifs.price_1		AS price_1_
					,companies_ext_tarifs.price_2		AS price_2_
					,companies_ext_tarifs.price_3		AS price_3_					
				   FROM
					 companies_tarifs
				   LEFT JOIN
					 companies_ext_tarifs ON companies_ext_tarifs.car_class_id = '.$car_class['class_id_'].'
				   AND
					 companies_ext_tarifs.period_id = '.$time_period['id_'].'
				   WHERE
					 companies_tarifs.car_class_id = '.$car_class['class_id_']);

     $res_tarifs1  = mysql_query('SELECT
					 companies_tarifs.base_price		AS base_price_
					,companies_ext_tarifs.ratio_1		AS ratio_1_
					,companies_ext_tarifs.ratio_2		AS ratio_2_
					,companies_ext_tarifs.ratio_3		AS ratio_3_
					,companies_ext_tarifs.price_1		AS price_1_
					,companies_ext_tarifs.price_2		AS price_2_
					,companies_ext_tarifs.price_3		AS price_3_					
				   FROM
					 companies_ext_tarifs
				   LEFT JOIN
					 companies_tarifs ON companies_tarifs.car_class_id = '.$car_class['class_id_'].'
				   WHERE
					 companies_ext_tarifs.car_class_id = '.$car_class['class_id_'].'
				   AND
					 companies_ext_tarifs.period_id = '.$time_period['id_']) or die(mysql_error());
 
     $row = mysql_fetch_assoc($res_tarifs);
     echo mysql_num_rows($res_tarifs);
?>
     <tr id="<?echo $time_period['id_'].$car_class['class_id_'];?>" car_class="<?echo $car_class['class_id_'];?>" base_price="<?echo $row['base_price_'];?>">
	  <td><?echo $car_class['class_name_'];?></td>
	  <td><?echo $row['base_price_'];?> руб./км.</td>
	  
	  <td style="text-align: center;"><input id="<?echo $time_period['id_'].$car_class['class_id_'];?>ratio_1" group="group1" class="ratio" type="text" size="5" value="<?echo $row['ratio_1_'];?>" /></td>
	  <td style="text-align: center;"><input id="<?echo $time_period['id_'].$car_class['class_id_'];?>price_1" group="group1" class="price" type="text" size="5" value="<?echo $row['price_1_'];?>" /></td>
	  
	  <td style="text-align: center;"><input id="<?echo $time_period['id_'].$car_class['class_id_'];?>ratio_2" group="group2" class="ratio" type="text" size="5" value="<?echo $row['ratio_2_'];?>" /></td>
	  <td style="text-align: center;"><input id="<?echo $time_period['id_'].$car_class['class_id_'];?>price_2" group="group2" class="price" type="text" size="5" value="<?echo $row['price_2_'];?>" /></td>
	  
	  <td style="text-align: center;"><input id="<?echo $time_period['id_'].$car_class['class_id_'];?>ratio_3" group="group3" class="ratio" type="text" size="5" value="<?echo $row['ratio_3_'];?>" /></td>
	  <td style="text-align: center;"><input id="<?echo $time_period['id_'].$car_class['class_id_'];?>price_3" group="group3" class="price" type="text" size="5" value="<?echo $row['price_3_'];?>" /></td>
     </tr>	  
<?

     }
     mysql_data_seek($res_car_classes, 0);
?>	  
			
     
   </table>   	  
	  
</div>  
<?php	}?>

   

   
   