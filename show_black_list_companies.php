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
   
   
   $res_companies = mysql_query(' SELECT black_list_company.owner_company,black_list_company.closed_company, black_list_company.user_id, black_list_company.datetime'.
   								', companies.company_name, jos_users.name '.
   								' FROM black_list_company '.
								' INNER JOIN companies ON black_list_company.closed_company = companies.company_id '.
								' INNER JOIN jos_users ON black_list_company.user_id = jos_users.id '.
								' WHERE black_list_company.owner_company = '.$company_id_								
								);

   
?>	   
<?php      echo 'Всего компаний: '.mysql_num_rows($res_companies);?>

   <table id="black_list_table" class="show_tables">
	   		<tr  class="componentheading">
				<th>Компания</th>
				<th>Кто добавил</th>
				<th>Дата добавления</th>
			</tr>
			<?php   for ($i_=0; $i_<mysql_num_rows($res_companies); $i_++){   ?>
      		<tr>
				<td align="center"><?php echo DB2Web(mysql_result($res_companies, $i_,4))?></td>
				<td align="center"><?php echo DB2Web(mysql_result($res_companies, $i_,5))?></td>
				<td align="center"><?php echo DB2Web(mysql_result($res_companies, $i_,3))?></td>
                    <td align="center">
                    	<a onclick="delete_company_from_black_list(<?php echo DB2Web(mysql_result($res_companies, $i_,1))?>)">
                        	<span id="fine_set_button" class="button" style="width:130px" >Убрать из списка</span>
                        </a>
                    </td>
			</tr>
			<?php	}  ?>
   </table>



