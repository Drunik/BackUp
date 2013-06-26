<?php 

function DB2Web( $text_){

     $out_="UTF-8";

	 $in_="Windows-1251";

     //return iconv($in_,$out_,stripslashes($text_));

	 return stripslashes($text_);

}





session_start();


   include_once('db_ini.php');

   

   $user_id_    = $_GET['user_id'];

   $company_id_ = $_GET['company_id'];

      

   $res_set = mysql_query(' SELECT drivers.driver_name, cars.model, cars.reg_number, cars.color, drivers_by_car.drivers_by_car_id FROM drivers_by_car '.

						  ' INNER JOIN cars ON cars.car_id = drivers_by_car.car_id'.

					      ' INNER JOIN drivers ON drivers.driver_id = drivers_by_car.driver_id WHERE drivers_by_car.company_id = '.$company_id_);

?>	   

   

   <table id="driver_car_table" class="show_tables">

	   		<tr  class="componentheading">

				<th align="center">Автомобиль</th>

				<th align="center">Водитель</th>

				<th></th>

			</tr>

			

<?php   for ($i_=0; $i_<mysql_num_rows($res_set); $i_++){   ?>



      			<tr>

						<td><?php echo DB2Web(mysql_result($res_set, $i_,1)).' '.DB2Web(mysql_result($res_set, $i_,2)).' '.DB2Web(mysql_result($res_set, $i_,3)) ?></td>

						<td><?php echo DB2Web(mysql_result($res_set, $i_,0))?></td>

						<td title="Удалить связку"><a class="button" href="#" onclick="del_car_driver(<?php echo DB2Web(mysql_result($res_set, $i_,4))?>); return false;">Убрать с линии</a></td>

				</tr>

<?php	}  

   $res_car = mysql_query('  SELECT DISTINCT cars.car_id, cars.model, cars.reg_number, cars.car_name FROM cars WHERE cars.company_id = '.$company_id_.

						'  AND 	cars.car_id NOT IN (SELECT DISTINCT car_id FROM drivers_by_car)');



   $res_driver = mysql_query('  SELECT DISTINCT drivers.driver_id, drivers.driver_name FROM drivers WHERE drivers.company_id = '.$company_id_.

						'  AND 	drivers.driver_id NOT IN (SELECT DISTINCT driver_id FROM drivers_by_car) ');



?>
</table>
<br/>
<table>

				<tr>

					<td><form method="post" name="car_driver_set_form" id="car_driver_set_form" action="">

							<select name="car_select" id="car_select">

								<option selected="selected" value="0">Выберите Автомобиль</option>

							<?php for ($i_=0; $i_<mysql_num_rows($res_car); $i_++){ ?>

								<option  value="<?php echo DB2Web(mysql_result($res_car, $i_,0))?>"><?php echo DB2Web(mysql_result($res_car, $i_,3))?></option>

<?php						}  ?>

							</select>

					</td>

					<td>

							<select name="driver_select" id="driver_select">

								<option selected="selected" value="0">выберите водителя</option>

							<?php for ($i_=0; $i_<mysql_num_rows($res_driver); $i_++){ ?>

								<option value="<?php echo DB2Web(mysql_result($res_driver, $i_,0))?>"><?php echo DB2Web(mysql_result($res_driver, $i_,1))?> 

<?php						}  ?>

							</select>

						</form>

					</td>

					<td title="Добавить связку"><a class="button" href="#" onclick="add_car_driver(); return false;">Добавить</a></td>

				</tr>
</table>






