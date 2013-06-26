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
   $filter_ = $_GET['filter'];
   
   if ($filter_ == 0)
     $filter_str = 'fines_entry.company_to_id = '.$company_id_.' OR fines_entry.company_from_id = '.$company_id_;
     
   if ($filter_ == 1)
     $filter_str = 'fines_entry.company_to_id = '.$company_id_;
     
   if ($filter_ == 2)
     $filter_str = 'fines_entry.company_from_id = '.$company_id_;     
   
/*   $res_fines = mysql_query(' SELECT 	fines_entry.id,
					fines_entry.datetime,
					fines.name,
					fines.amount,
					company_from.company_id,
					company_from.company_name,
					company_to.company_id,
					company_to.company_name,
					fines_entry.status
			      FROM 	fines_entry
			      INNER JOIN companies company_from ON company_from.company_id = fines_entry.company_from_id
   			      INNER JOIN companies company_to   ON company_to.company_id = fines_entry.company_to_id
   			      INNER JOIN fines ON fines.id = fines_entry.fines_id
			      WHERE fines_entry.company_from_id = '.$company_id_
			 );*/

   $res_fines = mysql_query(' SELECT 	fines_entry.id AS 		fine_id_,
					fines_entry.datetime AS 	fine_date_,
					fines.name AS 			fine_text_,
					fines.amount AS 		fine_amount_,
					company_from.company_id AS 	co_from_,
					company_from.company_name AS 	co_from_name_,
					company_to.company_id AS 	co_to_,
					company_to.company_name AS 	co_to_name_,
					fines_entry.status AS 		fine_status_
			      FROM 	fines_entry
			      INNER JOIN companies company_from ON company_from.company_id = fines_entry.company_from_id
   			      INNER JOIN companies company_to   ON company_to.company_id = fines_entry.company_to_id
   			      INNER JOIN fines ON fines.id = fines_entry.fines_id
			      WHERE '.$filter_str.'
			      ORDER BY fine_id_ DESC'
			 );			 
?>	   
					<select id="fines_filter" name="fines_filter" onchange="print_fines_list($(this).val());">
					     <option value="0">Все</option>
					     <option value="1"<?php if ($filter_ == 1) echo ' selected'?>>Выставленные мне</option>
					     <option value="2"<?php if ($filter_ == 2) echo ' selected'?>>Выставленные мной</option>
					</select>     




<?php      echo 'Активных претензии: '.mysql_num_rows($res_fines);?>

   <table id="fines_table" class="show_tables">
	   		<tr  class="componentheading">
				<th>№</th>
				<th>Дата</td>
				<th>Описание</th>
				<th>Стоимость</th>
				<th>Истец</th>
				<th>Ответчик</th>
				<th>Статус</th>
			</tr>
			
			
			<?php   while ($line = mysql_fetch_array($res_fines, MYSQL_ASSOC)){?>
			 <tr>
					<td>
					<a onclick="edit_fine(<?php echo DB2Web($line['fine_id_'])?>); return false;"><span id="driver_set_button" class="button"><?php echo DB2Web($line['fine_id_'])?></span>
					</a>
					</td>
					<td><?php echo DB2Web($line['fine_date_'])?></td>
					<td><?php echo DB2Web($line['fine_text_'])?></td>
					<td><?php echo DB2Web($line['fine_amount_'])?> руб.</td>
					<td><?php echo DB2Web($line['co_from_name_'])?></td>
					<td><?php echo DB2Web($line['co_to_name_'])?></td>
					<td><?php echo DB2Web($line['fine_status_'])?></td>
				</tr>
			<?php	}  ?>
			
   </table>



