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
   $res_cars = mysql_query(' SELECT cars.car_id
						     ,cars.class_id
						     ,cars.reg_number
						     ,cars.model
						     ,cars.color
						     ,cars.car_name
						     ,car_type.type_name
						     ,car_classes.class_name'.
   					' FROM cars '.
   					' INNER JOIN car_type ON car_type.id = cars.car_type'.
   					' LEFT JOIN car_classes ON car_classes.class_id = cars.class_id'.
   					' WHERE cars.company_id = '.$company_id_);
   
   $res_car_type = mysql_query(' SELECT id, type_name FROM  car_type');
   

   $res_car_classes1  = mysql_query('SELECT car_classes.class_id
							       ,car_classes.class_name
						  FROM tariff'.
						  ' INNER JOIN car_classes ON car_classes.class_id = tariff.Tariff_Type'.
						  ' WHERE company_id = '.$company_id_.
						  ' ORDER BY  car_classes.class_id');

     $res_car_classes =  mysql_query('SELECT
			     car_classes.class_id 		AS class_id_
			    ,car_classes.class_name 		AS class_name_
			    ,companies_tarifs.id		AS tarif_id_
			    ,companies_tarifs.car_class_id	AS car_class_
			    ,companies.default_car_class	AS default_car_class_
	     FROM companies_tarifs 
	     INNER JOIN car_classes ON car_classes.class_id = companies_tarifs.car_class_id
	     LEFT JOIN companies ON companies.company_id = '.$company_id_.'
	     WHERE companies_tarifs.company_id =  '.$company_id_.'
	     ORDER BY car_classes.class_id') or die(mysql_error());

   
?>	   
<?php      echo 'Всего автомобилей: '.mysql_num_rows($res_cars);?>
   <table id="cars_table" class="show_tables">
	   		<tr  class="componentheading">
				<th>Название</th>
				<th>Модель</th>
				<th>Гос. Номер</th>
				<th>Цвет</th>
				<th>Тип</th>
				<th>Класс Авто</th>
			</tr>
			<?php   for ($i_=0; $i_<mysql_num_rows($res_cars); $i_++){   ?>
      		<tr>
				<td><?php echo DB2Web(mysql_result($res_cars, $i_,5))?></td>
				<td><?php echo DB2Web(mysql_result($res_cars, $i_,3))?></td>
				<td><?php echo DB2Web(mysql_result($res_cars, $i_,2))?></td>
				<td><?php echo DB2Web(mysql_result($res_cars, $i_,4))?></td>
				<td><?php echo DB2Web(mysql_result($res_cars, $i_,6))?></td>
				<td><?php echo DB2Web(mysql_result($res_cars, $i_,7))?></td>
                    <td class="">
                    	<a onclick="DeleteCar(<?php echo DB2Web(mysql_result($res_cars, $i_,0))?>)">
                        	<span id="fine_set_button" class="button">Удалить</span>
                        </a>
                    </td>
			</tr>
<?php	}  ?>
		<tr class="slim">
		    <th colspan="7">Добавить новый Авто:</th>
		</tr>
		<tr>
			<td>						
				<input type="text" size="10" name="car_nomer" id="car_nomer" placeholder="Гос. Номер" /> 		
			</td>
			<td>						
				<input type="text" size="10" name="car_model" id="car_model" placeholder="Модель" /> 		
			</td>
			<td>						
				<input type="text" size="5" name="car_color" id="car_color" placeholder="Цвет" /> 		
			</td>
			<td align="left">	
				<input type="text" size="15" name="car_name"  id="car_name"  placeholder="Название" /> 
			</td>
			<td>
				<select name="car_type" id="car_type">
					<option selected="selected" value="0">Выберите Тип</option>
					<?php for ($i_=0; $i_<mysql_num_rows($res_car_type); $i_++){ ?>
						<option  value="<?php echo DB2Web(mysql_result($res_car_type, $i_,0))?>"><?php echo DB2Web(mysql_result($res_car_type, $i_,1))?></option>
					<?php	}  ?>
				</select>
			</td>
			<td>
				<select name="car_classes" id="car_classes">
			 <?	while ($line = mysql_fetch_assoc($res_car_classes)){
				    $selected = ''; 
				    if ($line['class_id_']==$line['default_car_class_'])
					$selected =' selected ';  		
					 
				 echo '<option value="'.$line['class_id_'].'" '.$selected.'>'.$line['class_name_'].'</option>';
				 }
			 ?>	
				</select>
			</td>
			<td>
				<a onclick="AddCar()">
					<span id="fine_set_button" class="button">Добавить</span>
				</a>
			</td>
		</tr>		

   </table>