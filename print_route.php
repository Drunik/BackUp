<?php
	include_once('db_ini.php');
	function DB2Web( $text_){
		 $out_="UTF-8";
		 $in_="Windows-1251";
		 //return iconv($in_,$out_,stripslashes($text_));
		 return stripslashes($text_);
	}

	$user_id = trim($_GET['user_id']);
	$query = " SELECT  id, street, house, porch, dolg, shir, sort FROM orders_adr WHERE session_id='".$_GET['sid']."' AND order_id=0 ORDER BY sort";
	$res = mysql_query($query);
	
	$coords = '[';
	for($i=0; $i<mysql_num_rows($res); $i++){  
		$coords .= '['.mysql_result($res, $i, 4).','.mysql_result($res, $i, 5).']';
		if ($i<mysql_num_rows($res)-1){
			$coords .= ', ';
		};
	} 
	$coords .= ']';	  
?>

<script>
	coords = <?php echo $coords ?> ;
<?php
//	$date_pod = date("Y-m-d");
	$date_pod = date("Y-m-d", time()+30*60);
//	$date_pod = date("d-m-Y", time()+30*60);
	$hours_pod = date("G", time()+30*60);
	$minutes_pod = date("i", time()+30*60);
	if ($minutes_pod>55){
		$minutes_pod = 55;
	}
?>	
	document.OrderForm.time_pod.value = <?php echo "'".$date_pod."'"; ?>;
	document.OrderForm.time_pod_hours.value = <?php echo $hours_pod; ?>;
	document.OrderForm.time_pod_min.value = Math.round(<?php echo $minutes_pod; ?>/5)*5;
	
	
</script>	
<?php
	function getValue($res_,$n_, $col){
		$result="";
		for($i_=0; $i_<mysql_num_rows($res_); $i_++){
			if (mysql_result($res_, $i_, "sort")==$n_){
				$result = mysql_result($res_, $i_, $col);
			}
		}
	//	return DB2Web($res);
		return $result;
	
	}

	$N = 0;    // кол-во строк с полями для ввода адреса
	if (mysql_num_rows($res)>0){
		$N = mysql_num_rows($res)+1;
	}else{
		$N = 2;
	}
	
?>
<script>
	$(document).ready(function(){	

		function liFormatStreet(row, i, num) {
			var result = row[0];
			return result;
		}	
		function liFormatOtkudaDom(row, i, num) {
			var result = row[0];
			return result;
		}	
		function selectItemOtkuda(li, num) {
			sValue = li.selectValue;
			setStreet(num, sValue);		
			point[0] = 0;					// Широта
			point[1] = 0;					// Долгота
		//	document.getElementById('koord1').value = point[1]+' '+point[0]; 

			if( li.extra[2]>0){
				point[0] = li.extra[3];
				point[1] = li.extra[2];
				showPoint(num);
				add_point(num);
			}else{
				document.getElementById('adr_domkorp'+num).disabled=false;
				document.getElementById('adr_domkorp'+num).value='';
				document.getElementById('adr_domkorp'+num).focus();
			}				
		}
		
		function selectItemOtkudaDom(li, num) {
			point[0] = li.extra[0];
			point[1] = li.extra[1];
			showPoint(num);
			add_point(num);
		//	document.getElementById('adr_street'+num+1).focus();
		}

<?php  
	for($i=0; $i<$N; $i++){
?>	
		$("#adr_street<?php echo $i?>").autocomplete("./my_source_codes/get_adr.php", {			//откуда улица
			delay:10,
			minChars:3,
			matchSubset:1,
			autoFill:false,
			matchContains:1,
			cacheLength:1,
			selectFirst:true,
			formatItem:liFormatStreet,
			maxItemsToShow:20,
			extraParams:{user_id:<?php echo $user_id ?>, num:<?php echo $i?>},
			onItemSelect:selectItemOtkuda<?php echo $i?>
		}); 
		$("#adr_domkorp<?php echo $i?>").autocomplete("./my_source_codes/get_dom.php", {			//// откуда № дома
			delay:10,
			minChars:0,
			matchSubset:1,
			autoFill:true,
			matchContains:1,
			cacheLength:1,
			selectFirst:true,
			formatItem:liFormatOtkudaDom,
			maxItemsToShow:20,
			extraParams:{user_id:<?php echo $user_id ?>, num:<?php echo $i?>},
			onItemSelect:selectItemOtkudaDom<?php echo $i?>
		}); 	
	
		function selectItemOtkuda<?php echo $i?>(li) {
				selectItemOtkuda(li, <?php echo $i?>); 
		}

		function selectItemOtkudaDom<?php echo $i?>(li) {
				selectItemOtkudaDom(li, <?php echo $i?>); 
		}

<?php	
	}
?>
	});
</script>
<table>
<?php	
	
	//echo $query;
//	if (mysql_num_rows($res)>0){
		for($i=0; $i<$N; $i++){
			$dis='';
			if((strlen(getValue($res, $i, 1))>0)&&(strlen(getValue($res, $i, 2))<=0)){
				$dis = 'disabled="disabled"';
			}	
?>
		<tr>
			<td><a href="#" onclick="showPoint2(<?php echo $i ?>); return false;"><?php echo ($i+1) ?></a></td>
			<td align="left"><input id="adr_street<?php echo $i ?>" name="adr_street<?php echo $i ?>" type="text" size="45" value="<?php echo getValue($res, $i, 1)?>"  /></td>
			<td>
				<input type="text" size="10" id="adr_domkorp<?php echo $i ?>" name="adr_domkorp<?php echo $i ?>" value="<?php echo getValue($res, $i, 2)?>" <?php echo $dis ?> /> 		
				<input type="text" size="5" id="adr_porch<?php echo $i ?>"  name="adr_porch<?php echo $i ?>" value="<?php echo getValue($res, $i, 3)?>"  <?php echo $dis ?> /> 
<?php /*				<img src="./img/up.png" width="18" height="18" />
				<img src="./img/down.png" width="18" height="18" />
				<img src="./img/del_icon.png" width="18" height="18" />
				<a href="#" onclick="add_point(<?php echo $i ?>);"><img src="./img/add.png" width="18" height="18" /></a>
*/ ?>				
			</td>
		</tr>
<?php				
		}
//	}
?>	

</table>