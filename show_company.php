<?php 

function DB2Web( $text_){

     $out_="UTF-8";

	 $in_="Windows-1251";

     //return iconv($in_,$out_,stripslashes($text_));

	 return stripslashes($text_);

}
function printHours($time_pod_hours){
   $txt='';
   for ($i_=0; $i_<24; $i_++){
	   $selected = ''; 
	   if ($i_==$time_pod_hours){
	   		$selected =' selected '; 
		}  
       $txt.= '<option value="'.$i_.'"'.  $selected.' >'.str_repeat("0", 2-strlen($i_)).$i_.'</option>'; 
   }
   return 	$txt;
}
function printMinutes($time_pod_min){
   $txt='';
   for ($i_=0; $i_<60; $i_+=5){
	   $selected = ''; 
	   if ($i_==$time_pod_min){
			$selected =' selected '; 
		}  
		$txt.= '<option value="'.$i_.'"'. $selected.' >'.str_repeat("0", 2-strlen($i_)).$i_.'</option>'; 
	}
	return 	$txt;
}


session_start();

   include_once('db_ini.php');

   $company_id_ = $_GET['company_id'];
   
   
   $res_set  = mysql_query('SELECT 	companies.company_name		AS company_name_,
						        all_sum					AS all_sum_,
							companies.Description			AS description_,
							companies.Phone_Number		AS phone_,
							companies.default_car_class		AS default_class_,
							agreement.DateFrom,
							agreement.DateTo,
							agreement.DayFrom,
							agreement.NightFrom,
							agreement.TariffPlan,
							agreement.TestPeriodTo
					FROM companies'.
					' INNER JOIN agreement ON agreement.Company_id = companies.company_id and Active = true'.
					' WHERE companies.company_id = '.$company_id_);
   
   $res_set_time  = mysql_query('SELECT tarif_time_periods.name 			AS name_time_,
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
   
     $res_set_all_classes  = mysql_query('SELECT * FROM car_classes ORDER BY class_id') or die(mysql_error());

     $res_car_classes1  = mysql_query('SELECT car_classes.class_id
							        ,car_classes.class_name
						  FROM tariff'.
						  ' INNER JOIN car_classes ON car_classes.class_id = tariff.Tariff_Type'.
						  ' WHERE company_id = '.$company_id_.
						  ' ORDER BY  car_classes.class_id');
     
     
      $res_car_classes1  = mysql_query('SELECT
								       car_classes.class_id 			AS class_id_
								      ,car_classes.class_name 		AS class_name_
								      ,companies_tarifs.id			AS tarif_id_
								      ,companies_tarifs.car_class_id	AS car_class_
								      ,companies_tarifs.min_sum		AS min_sum_
								      ,companies_tarifs.min_km		AS min_km_
								      ,companies_tarifs.base_price		AS base_price_			      
								      ,companies_tarifs.distance_1		AS distance_1_			      
								      ,companies_tarifs.distance_2		AS distance_2_			      
						       FROM
								      car_classes
						       INNER JOIN companies_tarifs ON companies_tarifs.company_id =  '.$company_id_.'
						       AND  companies_tarifs.car_class_id = car_classes.class_id
						       ORDER BY car_classes.class_id');
      

      $res_car_classes  = mysql_query('SELECT
								       car_classes.class_id 			AS class_id_
								      ,car_classes.class_name 		AS class_name_
								      ,companies_tarifs.id			AS tarif_id_
								      ,companies_tarifs.car_class_id	AS car_class_
								      ,companies_tarifs.min_sum		AS min_sum_
								      ,companies_tarifs.min_km		AS min_km_
								      ,companies_tarifs.base_price		AS base_price_			      
								      ,companies_tarifs.distance_1		AS distance_1_			      
								      ,companies_tarifs.distance_2		AS distance_2_			      
						       FROM companies_tarifs 
						       INNER JOIN car_classes ON car_classes.class_id = companies_tarifs.car_class_id 
						       WHERE companies_tarifs.company_id =  '.$company_id_.'
						       ORDER BY car_classes.class_id');



      
      $res_car_classes_new2 =  mysql_query('SELECT
								       car_classes.class_id 			AS class_id_
								      ,car_classes.class_name 		AS class_name_
								      ,companies_tarifs.car_class_id	AS car_class_
								     	      
						       FROM
								      car_classes
						       INNER JOIN  companies_tarifs ON car_classes.class_id = companies_tarifs.car_class_id 
						       ORDER BY car_classes.class_id');
      
      
         $res_car_classes_new = mysql_query('  SELECT
								       car_classes.class_id 			AS class_id_
								      ,car_classes.class_name 		AS class_name_				
						       FROM car_classes
						       WHERE class_id NOT IN (SELECT car_class_id FROM companies_tarifs WHERE company_id = '.$company_id_.')
						       ORDER BY class_id');
      
      
						  
//   $res_set_classes = mysql_query(' SELECT class_name FROM car_classes ORDER BY  class_id ');
	
     $row = mysql_fetch_assoc($res_set);
						  
?>
<script>
      $(document).ready(function(){
	  auto_height();
	  
	  $("#add_class_table input[type=checkbox]").click(function(){
	       var $parent = '#add_class_table',
		    $tr_id = $(this).closest("tr").attr("id"),
		    $this_ = $(this).attr("id");
		    
	       $($parent + " input[type=checkbox]").attr('checked', false);

	       $('#'+$this_).attr('checked',true);

	       default_car_class($tr_id);
	  });
	  
	  // Редактирование сущ. классов
	  $("#add_class_table input[type=text]").bind('input', function(){
	       $(this).css("background-color","#fff");
	       var $tr_id = $(this).closest("tr").attr("id"),
	       $id = $(this).attr("id");
	       
	       // Убираем с чекбоксов галочки и делаем их неактивными
	       // после ввода "правильных" символов они снова включатся
	       $('#defalt_class'+$tr_id).attr('disabled', true);
	       $('#defalt_class'+$tr_id).attr('checked', false);
	       // Проверяем является ли введенный символ числом
	       
	       if (/^[0-9]+$/.test($(this).val())) {
		    // Если поле Мин.сумма заказа заполнено, то даем возможность выбрать этот класс авто по цмолчанию
		    if ($('#min_sum'+$tr_id).val() > 0){
			 $('#defalt_class'+$tr_id).removeAttr("disabled");
		    }	 

		    edit_tarif($tr_id, $id);
		    
	       }
	       else{
		    $(this).css("background-color","#FFE4E1");	    
	       }
	       
	        $("#" + $tr_id + " input[type=text]").each(function(){
		    if (!/^[0-9]+$/.test($(this).val())){
			 $('#defalt_class'+$tr_id).attr('disabled', true);
			 $('#defalt_class'+$tr_id).attr('checked', false);
		    }
		});
	   });
	  // По умолчанию все ячейки красные, для добавления тарифа их нужно обязательно заполнить
	  $('#new_class input[type=text]').css("background-color","#FFE4E1");

	  // Выключаем кнопку Добавить
	  $('#add_new_class').attr('disabled','disabled');
	  
	  // При вводе информации ведем проверку всех полей
	  $('#new_class input[type=text]').bind('input', function(){
	      
	      var $n = 0; 
	       $("#new_class input[type=text]").each(function(){
		    if (/^[0-9]+$/.test($(this).val())){
			 $('#add_new_class').removeAttr("disabled");
			
		    }
		    else $n++;
 	      });
	       
	       // Если есть "неправильные" поля, то отключаем кнопку Добавить
	       if ($n > 0) $('#add_new_class').attr('disabled', 'disabled');
	       
	  });     
	  // Добавление нового класса
	  $("#add_class_table #add_new_class").click(function(){
	       var $id = $('#new_class_car_id').val();
	       add_tarif($id);
	       });
	  
	  // Удаление класса
	  $("#add_class_table #del_class").click(function(){
	       var $class_id = $(this).closest("tr").attr("id");
	       del_tarif($class_id);
	  });	  
/*	       
*/
//	       setTimeout(function(){add_tarif($tr_id, $id)}, 3000);
//	       add_tarif($(this).closest("tr").attr("id"), $(this).attr("id"));
//	       var $car_class_id = $(this).closest("tr").attr("id");
//	       alert($(this).val() + "-"+$("#min_sum"+$car_class_id).val());
	       
	});
</script>	   
   <table class="show_tables" style="max-width: 700px; text-align: left;">
      			<tr>
						<th width="160">Название компании</th>
						<td><?php echo DB2Web($row['company_name_'])?></td>
						<td rowspan="4" align="center">Логотип</td>
				</tr>
      			<tr>
						<th>Телефон</th>
						<td><?php echo DB2Web($row['phone_'])?></td>
				</tr>
      			<tr>
						<th>Выполнено заказов</th>
						<td>Надо вставить расчет</td>
				</tr>
      			<tr>
						<th>Добавлено заказов</th>
						<td>Надо вставить расчет</td>
				</tr>
      			<tr>
						<th>Описание</th>
						<td colspan="2"><?php echo DB2Web($row['description_'])?></td>
				</tr>
   </table>
<br/>
     <table id="add_class_table" class="show_tables" style="width: auto;">
	  <tr  class="componentheading">
		  <th>Тип Авто</th>
		  <th>Мин. Сумма Заказа</th>
		  <th>Мин. Кол-во Км</th>
		  <th>Базовая цена/км</th>
		  <th>Тариф по умолчанию</th>
		  <th></th>
	  </tr>
<?php
while ($line = mysql_fetch_assoc($res_car_classes)){
?>
	  <tr  id="<?php echo $line['class_id_'] ?>">
	       <td><?php echo $line['class_name_'] ?></td>
	       <td><input type="text" size="4" id="min_sum<?php echo $line['class_id_'] ?>" value="<?php echo DB2Web($line['min_sum_'])?>" /></td>
	       <td><input type="text" size="4" id="min_km<?php echo $line['class_id_'] ?>" value="<?php echo DB2Web($line['min_km_'])?>" /></td>
	       <td><input type="text" size="4" id="base_price<?php echo $line['class_id_'] ?>" value="<?php echo DB2Web($line['base_price_'])?>" /></td>
	       <td><input type="checkbox" id="defalt_class<?php echo $line['class_id_'] ?>"<?php if ($line['class_id_'] == $row['default_class_']) echo "checked";?>/></td>
	       <td><span id="del_class" class="button">Удалить</span></td>
	  </tr>
<?php
     }

  if (mysql_num_rows($res_car_classes_new) > 0){
     ?>
	  <tr class="slim">
	       <th colspan="6">
		    Добавить новый класс:
	       </th>    
	  </tr>	    
     
	  <tr id="new_class">
	       <td>
		    <select id="new_class_car_id">
<?
	       while ($line = mysql_fetch_assoc($res_car_classes_new)){
		    echo '<option value="'.$line['class_id_'].'">'.$line['class_name_'].'</option>';
	       }
?>			 
		    </select>
	       </td>
	       <td><input type="text" size="4" id="new_min_sum" value="" /></td>
	       <td><input type="text" size="4" id="new_min_km" value="" /></td>
	       <td><input type="text" size="4" id="new_base_price" value="" /></td>
	       <td colspan="2"><input type="button" id="add_new_class" class="button" value="Добавить" /></td>
	  </tr>
<?   }	?>	  
     
     </table>
     
     
<br/>
   <table id="add_time_table" class="show_tables" style="width: auto;">
			 <tr class="componentheading">
			      <th>Название</th>
			      <th>Время</th>
			      <th>Расстояние 1</th>
			      <th>Расстояние 2</th>
			      <th></th>   
			 </tr>     
 <?php   while ($line = mysql_fetch_assoc($res_set_time)){?>
      			<tr>
			      <td><input type="text" size="10" name="name_time" id="name_time" value="<?php echo DB2Web($line['name_time_'])?>" /></td>
			      <td style=" white-space:nowrap;">
				 с
				<select name="time_from_hours" id="time_from_hours" >
				 <?php echo printHours($line['time_from_hours_']) ?>
				</select>:
				<select name="time_from_min" id="time_from_min" >
				 <?php echo printMinutes($line['time_from_min_']) ?>
				</select>
				по
				<select name="time_to_hours" id="time_to_hours">
				 <?php echo printHours($line['time_to_hours_']) ?>
				</select>:
				<select name="time_to_min" id="time_to_min">
				 <?php echo printMinutes($line['time_to_min_']) ?>
				</select>
			      </td>
			      <td>
				<input type="text" size="7" name="distance_1" id="distance_1" value="<?php echo $line['distance_1_']?>"/>
			      </td>
			      <td>
				<input type="text" size="7" name="distance_2" id="distance_2" value="<?php echo $line['distance_2_'] ?>"/>
			      </td>
			      <td>
				<span id="del_time_period" class="button">Удалить</span>
			      </td>							
			</tr>

<?php	}?>
			 <tr class="slim">
			      <th colspan="5">
				   Добавить время дня:
			      </th>    
			 </tr>
      			<tr>
			      <td><input type="text" size="10" name="name_time" id="name_time" placeholder="Название"/></td>
			      <td style=" white-space:nowrap;">
				 с
				<select name="time_from_hours" id="time_from_hours" >
				 <?php echo printHours($_POST['time_from_hours']) ?>
				</select>:
				<select name="time_from_min" id="time_from_min" >
				 <?php echo printMinutes($_POST['time_from_min']) ?>
				</select>
				по
				<select name="time_to_hours" id="time_to_hours">
				 <?php echo printHours($_POST['time_to_hours']) ?>
				</select>:
				<select name="time_to_min" id="time_to_min">
				 <?php echo printMinutes($_POST['time_to_min']) ?>
				</select>
			      </td>
			      <td>
				<input type="text" size="7" name="distance_1" id="distance_1" placeholder="Кол-во км."/>
			      </td>
			      <td>
				<input type="text" size="7" name="distance_2" id="distance_2" placeholder="Кол-во км."/>
			      </td>
			      <td>
				<span id="add_time_period" class="button">Добавить</span>
			      </td>						
		        </tr>
    </table>
