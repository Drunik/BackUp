<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
var myMap=0;
var coords = new Array();			//массив координат
var addresses = new Array();		//адреса 
var point = new Array(0, 0);
var route=0;
var myPlacemark=0;
function closeOrder(order_id_){
	$.ajax({  
          url: "./my_source_codes/close_order.php?order_id="+order_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  
          cache: false,  
          success: function(html){  
		  		$("#debug").html(html); 
          }  
     });  
	show_my_orders();
	$("ul.tabs li").removeClass("active");
	document.getElementById('idTab1').addClass("active");
	$(".tab_content").hide();
	var activeTab = "#tab1";
	$(activeTab).fadeIn();
	return false;
}
function SetDriverCar(order_id_){
	var   driver_set_id = document.getElementById('driver_set').value;
	if (driver_set_id>0){
			$.ajax({  
				  url: "./my_source_codes/driver_set.php?order_id="+order_id_+"&driver_set_id="+driver_set_id,  
				  cache: false,  
				  success: function(html){  
						$("#debug").html(html); 
				  }  
			 }); 	
			show_my_orders();
			$("ul.tabs li").removeClass("active");
			document.getElementById('idTab1').addClass("active");
			$(".tab_content").hide();
			var activeTab = "#tab1";
			$(activeTab).fadeIn();
	}
	return false;
}
function Fined_Partner(order_id_){
            $.ajax({  
	           url: "./my_source_codes/add_fine.php?order_id="+order_id_+"&user_id="+<?php echo $_SESSION['user_id']?>+"&company_id=<?php echo $_SESSION['company_id']?>",  
                cache: false,  
                success: function(html){  
						$("#Fine").html(html); 
                }  
            });  
			$("ul.tabs li").removeClass("active");
			document.getElementById('idFine').addClass("active");
			$(".tab_content").hide();
			var activeTab = "#Fine";
			$(activeTab).fadeIn();
}
	function ShowCompany(company_id_){
            $.ajax({  
	           url: "./my_source_codes/show_company.php?company_id="+company_id_+"&company_id_cur=<?php echo $_SESSION['company_id']?>",  
                cache: false,  
                success: function(html){  
						$("#Company").html(html); 
                }  
            });  
			$("ul.tabs li").removeClass("active");
			document.getElementById('idCompany').addClass("active");
			$(".tab_content").hide();
			var activeTab = "#Company";
			$(activeTab).fadeIn();
}
function edit_order(order_id_){
	$.ajax({  
          url: "./my_source_codes/edit_order.php?order_id="+order_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  
          cache: false,  
          success: function(html){  
				$("#tab2").html(html); 
          }  
     });  
	$("ul.tabs li").removeClass("active");
	document.getElementById('idTab2').addClass("active");
	$(".tab_content").hide();
	var activeTab = "#tab2";
	$(activeTab).fadeIn();
	return false;
}
function submit_form(type_){
	document.getElementById('order_type').value = type_;
	document.getElementById('OrderForm').submit();
	coords.splice(0, coords.length); 
	addresses = new Array();
	route=0;
}
function hide(order_id_, value_){
	$.ajax({  
          url: "./my_source_codes/hide_order.php?order_id="+order_id_+"&value="+value_+"&sid=<?php echo session_id();?>&user_id=<?php echo $_SESSION['user_id']?>",  
          cache: false,  
          success: function(html){
				$("#debug").html(html);   
				print_hidden_orders();
          }  
     });
}
function clear_form(type_){
	$.ajax({  
          url: "./my_source_codes/del_adr.php?sid=<?php echo session_id();?>",  
          cache: false,  
          success: function(html){  
				$("#debug").html(html); 
          }  
     }); 
	coords.splice(0, coords.length); 
	document.getElementById('OrderForm').reset();
	showRoute();
}
function trim(string){
	return string.replace(/(^\s+)|(\s+$)/g, "");
}
function na_torgi(order_id_){
	rate=document.getElementById('rate_na_torgi').value;
	$.ajax({  
		url: "./my_source_codes/na_torgi.php?order_id="+order_id_+"&rate="+rate+"&company_id=<?php echo $_SESSION['company_id']?>",  
		cache: false,  
		success: function(html){  
		   $("#debug").html(html);  
		}  
	});      
	show_my_orders();
	$("ul.tabs li").removeClass("active");
	document.getElementById('idTab1').addClass("active");
	$(".tab_content").hide();
	var activeTab = "#tab1";
	$(activeTab).fadeIn();
	return false;
}
function Cancel_Order(order_id_){
	alert(':-( не работает');
}
function Client_to_Black_List(client_number_){
			$.ajax({  
                url: "./my_source_codes/add_client_black_list.php?company_id=<?php echo $_SESSION['company_id']?>&user_id=<?php echo $_SESSION['user_id']?>&client_number="+client_number_,  
 		        cache: false,  
   		        success: function(html){  
					$("#debug").html(html); 
          		}  
     		});      
}
function add_car_driver(){
	var   car_id =document.getElementById('car_select').value;
	var driver_id=document.getElementById('driver_select').value;
	if (car_id>0){
		if(driver_id>0){
			$.ajax({  
 		        url: "./my_source_codes/add_car_drv.php?car_id="+car_id+"&driver_id="+driver_id+"&company_id=<?php echo $_SESSION['company_id']?>",  
 		        cache: false,  
   		        success: function(html){  
     	        	loadCasrByDrivers(); 
          		}  
     		});      
		}
	}
}
function del_car_driver(car_drv_id){
	$.ajax({  
       url: "./my_source_codes/del_car_drv.php?car_drv_id="+car_drv_id+"&company_id=<?php echo $_SESSION['company_id']?>",  
          cache: false,  
          success: function(html){  
              loadCasrByDrivers(); 
        }  
     });      
}
function test(){
    var err=false;
	var phone = trim(document.OrderForm.phone.value+document.OrderForm.phone1.value+document.OrderForm.phone2.value+document.OrderForm.phone3.value);
	var err_msg = '';
    if (phone.length<10){	
	    err = true;
		err_msg = err_msg+' "Телефон клиента"';
	} 
/*
    if (trim(document.OrderForm.client_name.value).length<1){
	    err = true;
		err_msg = err_msg+' "Имя клиента" ';
	} 
*/
	var price =    document.OrderForm.price.value;
	var distance = document.OrderForm.distance.value;
	if (distance/distance){
	}else{
	    err = true;
		err_msg = err_msg+' "Расстояние(км)" ';
	} 
    if (price/price){
	}else{	
	    err = true;
		err_msg = err_msg+' "цена" ';
	} 
	if (err){
		err = true;
	    alert('Неверно заполнены следующие поля: '+err_msg);
	}
	return !err;
}
</script>
<?php
function printClasses($class_id, $db){
   $classes_query =  ' SELECT * FROM car_classes ORDER BY class_id ';
   $db->setQuery( $classes_query );   $temp_result = $db->Query();   $classes_array=$db->loadRowList();
   $txt='';
   for ($i_=0; $i_<$db->getNumRows($temp_result); $i_++){
	   $selected = ''; 
	   if ($classes_array[$i_][0]==$class_id){
	   		$selected =' selected '; 
		}  
       $txt.= '<option value="'.$classes_array[$i_][0].'"'.  $selected.' '.$dis.'>'.$classes_array[$i_][1].'</option>'; 
   }
   return 	$txt;
}
function fillDefTime($time_){
    if (strlen(trim($city_))<1){
		return date("Y-m-d");
	}else{
		return $metro_;
	}
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
function printRates(){
	$txt='';
	for ($i_=0; $i_<25; $i_++){
	   $selected = ''; 
	   if ($i_==10){
	   		$selected =' selected '; 
		}  
       $txt.= '<option value="'.$i_.'"'. $selected.' >'.$i_.'</option>'; 
   }
   return 	$txt;	
}
?>
<style type="text/css">
	ul.tabs {margin: 0;	padding: 0;	float: left;	list-style: none;	height: 26px;	width: 100%;}
	ul.tabs li {	float: left;	margin: 0;	padding: 0;	height: 26px;	line-height: 26px;	border-left: 1px solid #aaa;	overflow: hidden;	position: relative;	background: #6B95C5;	color:#FFF;}
	ul.tabs li a {text-decoration: none;color: #000;display: block;padding: 0 20px;outline: none;}
	ul.tabs li a:hover {background: #6B95C5;color:#000;	}
	html ul.tabs li.active, 
	html ul.tabs li.active a:hover  {background: #fff;height: 28px;}
	ul.tabs2 {margin: 0;	padding: 0;	float: left;	list-style: none;	height: 26px;	width: 100%;}
	ul.tabs2 li {	float: left;	margin: 0;	padding: 0;	height: 26px;	line-height: 26px;	border-left: 1px solid #aaa;	overflow: hidden;	position: relative;	background: #6B95C5;	color:#FFF;}
	ul.tabs2 li a {text-decoration: none;color: #000;display: block;padding: 0 20px;outline: none;}
	ul.tabs2 li a:hover {background: #6B95C5;color:#000;	}
	html ul.tabs2 li.active, 
	 html ul.tabs2 li.active a:hover  {background: #fff;height: 28px;}
	.tab_container {overflow: hidden;clear: both;float: left; width: 100%;background: #fff;}
	.tab_content {padding: 20px;}	
	.tab_content2 {padding: 20px;}	
	body{font: 62.5% "Trebuchet MS", sans-serif;margin: 50px;}.
	demoHeaders {margin-top: 2em;}
	#dialog-link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
	#dialog-link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
	#icons {margin: 0;padding: 0;}
	#icons li {margin: 2px;position: relative;padding: 4px 0;cursor: pointer;float: left;list-style: none;}
	#icons span.ui-icon {float: left;margin: 0 4px;}
	.fakewindowcontain .ui-widget-overlay {position: absolute;}
	.ac_results {padding: 0px;border: 1px solid WindowFrame;background-color: Window;overflow: hidden;}
	.ac_results ul {
		width: 100%;list-style-position: outside;list-style: none;padding: 0;margin: 0;}
	.ac_results iframe {display:none;/*sorry for IE5*/display/**/:block;/*sorry for IE5*/position:absolute;top:0;left:0;z-index:-1;filter:mask();width:3000px;height:3000px;}
	.ac_results li {position:relative;margin: 0px;padding: 2px 5px;cursor: pointer;display: block;width: 100%;font: menu;font-size: 12px;overflow: hidden;}
	.ac_loading {background : Window url('autocomplete_indicator.gif') right center no-repeat;}
	.ac_over {background-color: Highlight;color: HighlightText;}
	#adr_street {
	  font-family: "Trebuchet MS", Tahoma, Verdana, Arial, Helvetica, sans-serif;
	  font-size: 10pt;
	}
	#naznach {
	  font-family: "Trebuchet MS", Tahoma, Verdana, Arial, Helvetica, sans-serif;
	  font-size: 10pt;
	}	
</style>
 <script>  
        function show()  
        {  
            $.ajax({  
                url: "./my_source_codes/print_orders.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>",  
                cache: false,  
                success: function(html){  
                    $("#order_conteiner").html(html);  
                }  
            });  
        }  
        $(document).ready(function(){  
            show();  
            setInterval('show()',1000);  
        });        
		 function bet(order_id, user_id, company_id)  
        {  
            $.ajax({  
                url: "./my_source_codes/bet.php?order_id="+order_id+"&user_id="+user_id+"&company_id="+company_id,  
                cache: false,  
				success: function(html){ 
 	             }
            });
			show();  
       }  
		 function cancel_order(order_id, user_id, company_id)  
        {  
          $.ajax({  
                url: "./my_source_codes/cancel_order.php?order_id="+order_id+"&user_id="+user_id+"&company_id="+company_id,  
                cache: false,  
				success: function(html){ 
               }
            }); 
        }  
		 function stop(order_id)  
        {  
            $.ajax({  
                url: "./my_source_codes/stop.php?order_id="+order_id,  
                cache: false,  
				success: function(html){ 
				    $("#debug").html(html);  
                }
            }); 
       }  
		function loadCasrByDrivers(){
            $.ajax({  
               url: "./my_source_codes/set_driver_car.php?company_id=<?php echo $_SESSION['company_id']?>",  
               cache: false,  
               success: function(html){  
                  $("#cont4").html(html);  
               }  
            });  
		}
		function loadHistory(){
            $.ajax({  
               url: "./my_source_codes/print_history.php?company_id=<?php echo $_SESSION['company_id']?>",  
                cache: false,  
               success: function(html){  
                   $("#cont3").html(html);  
                }  
            });  
		}
		 function show_my_orders()  
        {  
           $.ajax({  
             url: "./my_source_codes/print_my_orders.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>",  
               cache: false,  
                success: function(html){  
                    $("#my_orders").html(html);  
                }  
            });  
       } 		
		 function loadNewOrder()  
        {  
            $.ajax({  
                url: "./my_source_codes/new_order.php",  
                cache: false,  
                success: function(html){  
                    $("#tab2").html(html);  
                }  
            });  
        } 		
		 function AddFine()  
        {  
            $.ajax({  
               url: "./my_source_codes/add_fine.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>",  
                cache: false,  
                success: function(html){  
                    $("#Fine").html(html);  
                }  
            });  
        } 		
	$(document).ready(function(){  
		show_my_orders();  
		setInterval('show_my_orders()',5000);  
	});  
	 function show_balance(){  
		$.ajax({  
			url: "./my_source_codes/load_balance.php?company_id=<?php echo $_SESSION['company_id']?>",  
			cache: false,  
			success: function(html){  
				$("#balance").html(html);  
			}  
		});  
	} 				
	function print_hidden_orders(){
		$.ajax({  
			url: "./my_source_codes/print_hidden_orders.php?user_id=<?php echo $_SESSION['user_id']?>",  
			cache: false,  
			success: function(html){  
				$("#hidden_orders").html(html);  
			}  
		});  	
	}	
	$(document).ready(function(){  
		show_balance();  
		setInterval('show_balance()',5000);  
	});  
	$(document).ready(function() {
		$(".tab_content").hide(); //Скрыть все содержимое
		$(".tab_content2").hide(); //Скрыть все содержимое
		$("ul.tabs li:first").addClass("active").show(); //Активировать первую вкладку
		$("ul.tabs2 li:first").addClass("active").show(); //Активировать первую вкладку
		$(".tab_content:first").show(); //Показать первые содержание вкладке
		$(".tab_content2:first").show(); //Показать первые содержание вкладке
		$("ul.tabs li").click(function() {
			$("ul.tabs li").removeClass("active");
			$(this).addClass("active"); //добавить класс "active" к выбраной вкладке
			$(".tab_content").hide(); //Скрыть вкладку и ее содержание
			var activeTab = $(this).find("a").attr("href"); //Найти значение атрибута для выявления активной вкладки с содержанием
			$(activeTab).fadeIn(); //
			if ($(this).find("a").attr("href")=='#tab4'){
				loadCasrByDrivers(<?php echo $_SESSION['company_id']?>);
			};
			if ($(this).find("a").attr("href")=='#tab2'){
				loadNewOrder();
			};
			if ($(this).find("a").attr("href")=='#tab3'){
				loadHistory();
			};
			if ($(this).find("a").attr("href")=='#Company'){
				ShowCompany(<?php echo $_SESSION['company_id']?>);
			};
			if ($(this).find("a").attr("href")=='#Fine'){
				AddFine(<?php echo $_SESSION['company_id']?>);
			};
			return false;
		});
		$("ul.tabs2 li").click(function() {
				// обработка нажатий закладок в парвой части
			$("ul.tabs2 li").removeClass("active");
			$(this).addClass("active"); //добавить класс "active" к выбраной вкладке
			$(".tab_content2").hide(); //Скрыть вкладку и ее содержание
			var activeTab = $(this).find("a").attr("href"); //Найти значение атрибута для выявления активной вкладки с содержанием
			$(activeTab).fadeIn(); //
			if ($(this).find("a").attr("href")=='#hidden_orders'){
				print_hidden_orders();
			};
		});
	});		
	function setStreet(num_, street_){
	/*
	  $.ajax({  
			url: "./my_source_codes/set_street.php?user_id=<?php echo $_SESSION['user_id'] ?>&num="+num_+"&street="+street_,
			cache: false,  
			success: function(html){  
				$("#debug").html(html);  
			}  
		});
*/
		$.post("./my_source_codes/set_street.php", { user_id: "<?php echo $_SESSION['user_id'] ?>", num: num_, street: street_},
  			function(html){
    			$("#debug").html(html); 
  			}, 
		"xml");	
		//alert(555);	
	}
// обработка автозаполнения в разных полях
	$(document).ready(function(){	
		$("#adr_street").autocomplete("./my_source_codes/get_adr.php", {			//откуда улица
			delay:10,
			minChars:1,
			matchSubset:1,
			autoFill:false,
			matchContains:1,
			cacheLength:1,
			selectFirst:true,
			formatItem:liFormatStreet,
			maxItemsToShow:20,
			onItemSelect:selectItemOtkuda
		}); 
		$("#adr_domkorp").autocomplete("./my_source_codes/get_dom.php", {			//// откуда № дома
			delay:10,
			minChars:0,
			matchSubset:1,
			autoFill:false,
			matchContains:1,
			cacheLength:1,
			selectFirst:true,
			formatItem:liFormatOtkudaDom,
			maxItemsToShow:20,
			extraParams:{user_id:<?php echo $_SESSION['user_id'] ?>, num:1},
			onItemSelect:selectItemOtkudaDom
		}); 	
		function liFormatStreet(row, i, num) {
			var result = row[0];
			return result;
		}	
		function liFormatOtkudaDom(row, i, num) {
			var result = row[0];
			return result;
		}		
		function selectItemOtkuda(li) {
			sValue = li.selectValue;
			setStreet(1, li.selectValue);		
			point[0]=0;					// Широта
			point[1]=0;					// Долгота
			if( li.extra[2]>0){
				point[0] = li.extra[3];
				point[1] = li.extra[2];
			}	
			document.getElementById('koord1').value = point[1]+' '+point[0]; 
			document.getElementById('adr_domkorp').value='';
			document.getElementById('adr_domkorp').focus();
			showPoint();
		}		
		function selectItemOtkudaDom(li) {
			point[0] = li.extra[0];
			point[1] = li.extra[1];
			document.getElementById('koord1').value = point[1]+' '+point[0]; 
		showPoint();
		}
	});
    function add_point(){
//		l = coords.length;
//		coords[l] = [ point[0], point[1] ];
//		addresses[l] = ''+document.getElementById('adr_street').value+', '+document.getElementById('adr_domkorp').value;
/*
		$.ajax({  
			url: "./my_source_codes/add_adr.php?str="+document.getElementById('adr_street').value+"&house="+document.getElementById('adr_domkorp').value+
					"&adr_porch="+document.getElementById('adr_porch').value+"&shir="+point[1]+"&dolg="+point[0]+"&sid=<?php echo session_id();?>",  
			cache: false,  
			success: function(html){  
				$("#debug").html(html); 
				showRoute();
			}  
		}); 	
		*/
		$.post("./my_source_codes/add_adr.php", 
			{ str: document.getElementById('adr_street').value, house: document.getElementById('adr_domkorp').value, adr_porch: document.getElementById('adr_porch').value, shir: point[1], dolg: point[0], sid:"<?php echo session_id();?>"},
  			function(html){
    			$("#debug").html(html); 
 			}, 
		"xml");	
		showRoute();
		document.getElementById('adr_street').value=''; 
		document.getElementById('adr_domkorp').value=''; 
		document.getElementById('adr_porch').value='';
	}
	function showPoint(){
		$("ul.tabs li").removeClass("active");
		document.getElementById('idMap').addClass("active");
		$(".tab_content").hide();
		var activeTab = "#Map";
		$(activeTab).fadeIn();
		if ((point[0]>0)&&(point[1]>0)){
			myMap.geoObjects.remove(myPlacemark);
			myPlacemark = new ymaps.Placemark([point[1], point[0]],
				{
					iconContent: document.getElementById('adr_street').value+ ' '+document.getElementById('adr_domkorp').value,
					balloonContentHeader: '',
					balloonContentBody: document.getElementById('adr_street').value+ ' '+document.getElementById('adr_domkorp').value,
				},
				{preset: 'twirl#blueStretchyIcon'}
			);
			myMap.geoObjects.add(myPlacemark);
			myMap.setCenter([point[1], point[0]], 16);
		}
	}
	function calcPrice(){
		var RouteLength = document.getElementById('distance').value; 
		var RouteDiscount = document.getElementById('discount').value; 
		if (RouteDiscount>0){
			RoutePrice = RouteLength * 35 * (100-RouteDiscount) / 100;
		}else{
			RoutePrice = RouteLength * 35; 
		}
		RoutePrice = Math.round(RoutePrice/5);
		document.getElementById('price').value = RoutePrice*5; 
	}
	function calcRoute(){
//		alert(coords.length);
		if (coords.length>=2){
//			myMap.removeAllOverlays();
			myMap.geoObjects.remove(myPlacemark);
			str = new Array(coords.length);
			var geo=[];
			for(var i=0; i<coords.length; i++){
				str[i]=[coords[i][1], coords[i][0]];
			}
            myRoute = ymaps.route(
					str,
					{
               mapStateAutoApply: true // автоматически позиционировать карту
           }).then(function (router) {
				route && myMap.geoObjects.remove(route);
				route = router;
               myMap.geoObjects.add(route);
				var routeLength = Math.round(route.getLength()/100)/10; // Возвращает длину пути в метрах				
//				var routeHumanJamsTime = Math.round(route.getHumanJamsTime()/60); // Возвращает строковое представление времени проезда пути с единицами измерения с учетом пробок.				
				var routeHumanJamsTime = Math.round(route.getTime()/60); // Возвращает строковое представление времени проезда пути с единицами измерения с учетом пробок.				
  				document.getElementById('distance').value = routeLength; 
  				document.getElementById('HumanJamsTime').value = routeHumanJamsTime; 
				calcPrice();
            }, function (error) {
                alert("Возникла ошибка: " + error.message);
            });
			$("ul.tabs li").removeClass("active");
			document.getElementById('idMap').addClass("active");
			$(".tab_content").hide();
			var activeTab = "#Map";
			$(activeTab).fadeIn();
		}else{
			if (coords.length==0){
				myMap.geoObjects.remove(route);
			}	
		}
	}
	ymaps.ready(init);
	function init () {
		myMap = new ymaps.Map("cont7", {
				center: [59.94, 30.31],
				zoom: 10,
				behaviors: ['drag','scrollZoom']
			});
		myMap.controls
			.add('zoomControl')      // Кнопка изменения масштаба
			.add('typeSelector');    // Список типов карты
		showRoute();
		calcRoute();	
	}
	function showRoute(){
	  $.ajax({  
			url: "./my_source_codes/print_route.php?sid=<?php echo session_id();?>",
			cache: false,  
			success: function(html){  
				$("#adr_conteiner").html(html); 
				calcRoute(); 
			}  
		});
	}
</script>
<?php $left_half_wid = 700; 
	  $left_half_hei = 500; 
?>
	<table border="0" >
	<tr>
		<td valign="top">
			<table cellpadding="0" cellspacing="0" width="<? echo $left_half_wid?>" border="0" align="left">
				<tr>
					<td align="left" colspan="2">
						<span id="adr_conteiner" align="left">
						</span>
					</td>
				</tr>
				<tr>
					<td align="left">	
						<input type="text" size="45" name="adr_street"  id="adr_street"  placeholder="Адрес" required /> 
					</td>
					<td>						
						<input type="text" size="10" name="adr_domkorp" id="adr_domkorp" placeholder="Дом" /> 		
						<input type="text" size="5" name="adr_porch" id="adr_porch" placeholder="Подъезд"/> 		
					</td>
					<td>						
						<input type="text" size="10" name="koord1"  id="koord1" disabled="disabled"/> 
					</td>
					<td>
						<span id="add" class="button" onclick="add_point();" style="width:50">Добавить</span> 
					</td>
				</tr>						
			</table>
		<form id="OrderForm" name="OrderForm" method="post" onSubmit="return test();" action="./index.php?option=com_content&view=article&id=56&Itemid=51&addpar=orders&act=add">
			<table cellpadding="0" cellspacing="0" width="<? echo $left_half_wid?>" border="0">
				<tr>
					<td>
						<input type="hidden" id="sid" name="sid" value="<?php echo session_id();?>"  />
						<span  class="componentheading"><a href="#" onclick="calcRoute();  return false">км *</a></span>
						<input type="text" size="8" id="distance" name ="distance" onchange="calcPrice()"/> 
					</td>
					<td>
						<span  class="componentheading">в пути</span>
						<input type="text" size="8" id="HumanJamsTime" name ="HumanJamsTime" /> 
					</td>
					<td>
						<span  class="componentheading">Стоимость *</span>
						<input type="text" size="8" id="price" name="price"/> 
					</td>
					<td>
						<span  class="componentheading">Скидка</span>
						<input type="text" size="8" id="discount" name="discount" placeholder="Скидка" onchange="calcPrice()"/> 
						<span  class="componentheading">%</span>
					</td>
				<tr>
				</tr>
					<td colspan="2">
						<span class="componentheading">время</span>
						<input type="text"  name="time_pod"  id="time_pod" size="9" value="<?php echo fillDefTime($_POST['time_pod']) ?>"  
									onclick="return showCalendar('time_pod', 'y-mm-dd');"/>
					<select name="time_pod_hours" id="time_pod_hours" >
						<?php echo printHours($_POST['time_pod_hours']) ?>
					</select>:
					<select name="time_pod_min" id="time_pod_min" >
						<?php echo printMinutes($_POST['time_pod_min']) ?>
					</select>
					</td>
					<td>	
                    <select name="class_auto" id="class_auto"> <?php echo printClasses(1, $db) ?> </select>
					</td>
				<td>
						<span id="order_button"  style="background-color:#663366" >
							<ul class="tabs" >
								<li align="right"><a style="background-color:#6B95C5; font-size:12px; color:#FFF;" id="idTab2" href="#tab2">Оформить заказ</a></li>
							 </ul>
						</span>
					</td>
				</tr>
		</table>
    	<table border="0" bgcolor="#FFFFFF">
			<tr><td colspan="6">
					<div class="tab_container" style="overflow-x:hidden; overflow-y:scroll">
						<div id="tab1" class="tab_content">
							<div id="my_orders" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px"></div>                
						</div>		
						<div id="tab2" class="tab_content">
							<div id="cont2" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px"></div>       
						</div>
						<div id="tab3" class="tab_content">
							<div id="cont3" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px"></div>
						</div>
						<div id="tab4" class="tab_content">
							<div id="cont4" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px"></div>
						</div>
						<div id="tab5" class="tab_content">
							<div id="cont5" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px"></div>
						</div>
						<div id="tab6" class="tab_content">
							<div id="cont6" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px"></div>
						</div>
						<div id="Map" class="tab_content">
							<div id="cont7" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px">
							</div>
						</div>
						<div id="Company" class="tab_content">
							<div id="Company" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px">
							</div>
						</div>
						<div id="Fine" class="tab_content">
							<div id="Fine" style="width: <? echo $left_half_wid?>px; height: <? echo $left_half_hei?>px">
							</div>
						</div>
					</div>
					<ul class="tabs" id="idul1">
						<li><a href="#tab1" id="idTab1">Активные</a></li>
						<li><a href="#tab3" id="idTab3">История</a></li>
						<li><a href="#tab4" id="idTab4">На линии</a></li>
						<li><a href="#tab5" id="idTab5">Настройка</a></li>
						<li><a href="#tab6" id="idTab6">Кто On-Line</a></li>
						<li><a href="#Map"  id="idMap">Карта</a></li>
						<li><a href="#Company" id="idCompany">Компания</a></li>
						<li><a href="#Fine" id="idFine">Претензии</a></li>
					</ul>
				</div>
				</td></tr>
			</table>
		</form>	
		</td>
		<td width="800" valign="top"  height="700">
			<div class="tab_container" style="overflow-x:hidden; overflow-y:scroll; width:100%">
				<ul class="tabs2" id="idul2">
					<li style="width:19%"><a href="#stock" id="idStock">Площадка</a></li>
					<li style="width:19%"><a href="#hidden_orders" id="idHidden">Скрытые заказы</a></li>
					<li style="width:19%"><a href="#compaies_onlinr" id="idCompOnLine">Компании On-Line</a></li>
					<li style="width:19%"><a href="#black_list" id="idBlackList">Черный список</a></li>
					<li style="width:19%"><a href="#claim" id="idClaim">Претензии</a></li>
				</ul>		
				<div id="stock" class="tab_content2">
					<div class="componentheading">Обмен заказами <?php // echo session_id()?></div>
					<div id="order_conteiner"  style="overflow-x:hidden; overflow-y:scroll; height:700" height="700" > </div>  	
					<div id="debug" name="debug" >debug </div> 
				</div>	
				<div id="hidden_orders" class="tab_content2" >
					Скрытые заказы
				</div>
				<div id="compaies_onlinr" class="tab_content2">
					Компании On-Line
				</div>
				<div id="black_list" class="tab_content2">
					Черный список
				</div>
				<div id="claim" class="tab_content2">
					Претензии
				</div>
			</div> 	 	
		</td> 
		</tr>
</table>
