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
   
   
   $res_companies = mysql_query(' SELECT companies.company_id,companies.company_name, companies.Phone_Number '.
   								' FROM companies '.
   								' LEFT JOIN black_list_company ON companies.company_id = black_list_company.closed_company '.
   								' WHERE black_list_company.owner_company is NULL'.
								' and companies.company_id != '.$company_id_								
								);

   
?>	   
<?php      echo 'Всего компаний: '.mysql_num_rows($res_companies);?>

   <table id="companies_table" class="show_tables">
	   		<tr  class="componentheading">
				<th>Название</th>
				<th>Телефон</th>
			</tr>
			<?php   for ($i_=0; $i_<mysql_num_rows($res_companies); $i_++){   ?>
      		<tr>
				<td align="center"><?php echo DB2Web(mysql_result($res_companies, $i_,1))?></td>
				<td align="center"><?php echo DB2Web(mysql_result($res_companies, $i_,2))?></td>
                    <td align="center">
                    	<a onclick="add_company_to_black_list(<?php echo DB2Web(mysql_result($res_companies, $i_,0))?>)">
                        	<span id="fine_set_button" class="button">В черный список</span>
                        </a>
                    </td>
			</tr>
			<?php	}  ?>
   </table>



