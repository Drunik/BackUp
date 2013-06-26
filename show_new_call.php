<?php
   $phone_ =   $_GET['phone'];
?>
			 <div id="<?echo $phone_;?>" class="top_new_call">
			  <table id="inc_call_table" class="show_tables_nohover">
			   <tr>
				   <td><span class="button"><img src="/img/add.png" width="20" height="20" border="0"></span></td>
				   <th>Имя</th>
				   <td colspan="3">Иванов Иван Иванович</td>
			   </tr>
			   <tr>
				   <td><span class="button"><img src="/img/del_icon.png" width="20" height="20" border="0"></span></td>
				   <th>Телефон</th>
				   <td><?echo $phone_;?></td>
				   <th>Карта №</th>
				   <td>98989</td>
			   </tr>
			  </table>	
			 </div>