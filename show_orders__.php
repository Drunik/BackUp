<?php 

//	if (strlen(trim($_POST['modlgn_username']))>1){

?>

<script>

//	alert('<?php echo $_POST['modlgn_passwd']; ?>');

	//alert(document.getElementById('modlgn_passwd').value);	

	document.getElementById('modlgn_username').value='<?php echo $_POST['modlgn_username']; ?>';

	document.getElementById('modlgn_passwd').value='<?php echo $_POST['modlgn_passwd']; ?>';



	

//	document.getElementById('form-login').submit();

</script>	

<?php

//	}

?>



<script type="text/javascript">

var myMap=0;

var coords = new Array();			//массив координат

var addresses = new Array();		//адреса 

var point = new Array(0, 0);

var route=0;

var myPlacemark=0;

var channels = new Array();



function bookmark_activate(id_, tab_){

	$("ul.tabs li").removeClass("active");

	$(id_).addClass("active");

	$(".tab_content").hide();

	var activeTab = tab_;

	

	$(activeTab).fadeIn();	

}



function edit_order(order_id_){

	$.ajax({  

          url: "./my_source_codes/edit_order.php?order_id="+order_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

          cache: false,  

          success: function(html){  

				$("#NewOrder").html(html); 

          }  

    });

	bookmark_activate('idNewOrder', '#NewOrder');

	return false;

}

function closeOrder(order_id_){

	$.ajax({  

          url: "./my_source_codes/close_order.php?order_id="+order_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

          cache: false,  

          success: function(html){  

		  		$("#debug").html(html); 

          }  

     });  

	show_my_orders();

	bookmark_activate('idMyOrders', "#MyOrders");

	return false;

}

function Fined_Partner(order_id_){

            $.ajax({  

	           url: "./my_source_codes/new_fine.php?order_id="+order_id_+"&user_id="+<?php echo $_SESSION['user_id']?>+"&company_id=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#Fine").html(html); 

                }  

            });  



			$(".tab_content").hide();

			var activeTab = "#Fine";

			$(activeTab).fadeIn();

}

function AddFine(order_id_){

	$.ajax({  

	   url: "./my_source_codes/add_fine.php?user_from_id=<?php echo $_SESSION['user_id']?>

			&company_from_id=<?php echo $_SESSION['company_id']?>"+

			"&fines_id="+$('#fine_id').val()+

			"&order_id="+order_id_+

			"&company_to_id="+$('#defendant_set').val()+

			"&comment_from="+$('#comment').val()

	   , cache: false,  

		success: function(html){  

				$("#debug").html(html); 

		}  

	});

		

	document.getElementById('idMyOrders').addClass("active");

	$(".tab_content").hide();

	var activeTab = "#MyOrders";

	$(activeTab).fadeIn();



	print_fines_list(0);

	

	$("ul.tabs2 li").removeClass("active");

	document.getElementById('idFines_List').addClass("active");

	$(".tab_content2").hide();

	var activeTab = "#fines_list";

	$(activeTab).fadeIn();

	return false;	

}



function ShowCompany(company_id_){

            $.ajax({  

	           url: "./my_source_codes/show_company.php?company_id="+company_id_+"&company_id_cur=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#Company").html(html); 

                }  

            });  

			$(".tab_content").hide();

			var activeTab = "#Company";

			$(activeTab).fadeIn();

}

function ShowTarifs(company_id_){

            $.ajax({  

	           url: "./my_source_codes/show_company_tarifs.php?company_id="+company_id_+"&company_id_cur=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#Tarifs").html(html); 

                }  

            });  

			$(".tab_content").hide();

			var activeTab = "#Tarifs";

			$(activeTab).fadeIn();

}

function ShowCars(company_id_){

            $.ajax({  

	           url: "./my_source_codes/show_cars.php?company_id=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#Cars").html(html); 

                }  

            });  

			$(".tab_content").hide();

			var activeTab = "#Cars";

			$(activeTab).fadeIn();

}

function DeleteCar(cars_id_){

            $.ajax({  

	           url: "./my_source_codes/delete_car.php?cars_id="+cars_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#debug").html(html); 

                }  

            }); 

			ShowCars(<?php echo $_SESSION['company_id']?>);

}

function AddCar(){

            $.ajax({  

	           url: "./my_source_codes/add_car.php?user_id=<?php echo $_SESSION['user_id']?>

			   &company_id=<?php echo $_SESSION['company_id']?>"

			   +"&car_name="+document.getElementById('car_name').value

			   +"&car_model="+document.getElementById('car_model').value

			   +"&car_nomer="+document.getElementById('car_nomer').value

			   +"&car_color="+document.getElementById('car_color').value

			   +"&car_type="+document.getElementById('car_type').value

			   +"&car_classes="+document.getElementById('car_classes').value

			   , cache: false,  

                success: function(html){  

						$("#debug").html(html); 

                }  

            }); 

			ShowCars(<?php echo $_SESSION['company_id']?>);

	}

function ShowClients(){

            $.ajax({  

	           url: "./my_source_codes/show_clients.php?company_id=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#Clients").html(html); 

                }  

            });  

			$(".tab_content").hide();

			var activeTab = "#Clients";

			$(activeTab).fadeIn();

}

function AddClient(){

            $.ajax({  

	           url: "./my_source_codes/add_client.php?user_id=<?php echo $_SESSION['user_id']?>

			   &company_id=<?php echo $_SESSION['company_id']?>"

			   +"&client_phone="+document.getElementById('client_phone').value

			   +"&client_description="+document.getElementById('client_description').value

			   +"&client_no_cash="+document.getElementById('client_no_cash').value

			   , cache: false,  

                success: function(html){  

						$("#debug").html(html); 

                }  

            }); 

			ShowClients();

	}

function DeleteClient(client_id_){

            $.ajax({  

	           url: "./my_source_codes/delete_client.php?client_id="+client_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#debug").html(html); 

                }  

            }); 

			ShowClients();

}

function ShowDrivers(driver_id_){

            $.ajax({  

	           url: "./my_source_codes/show_drivers.php?company_id=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#Drivers").html(html); 

                }  

            });  

			$(".tab_content").hide();

			var activeTab = "#Drivers";

			$(activeTab).fadeIn();

}

function DeleteDriver(driver_id_){

            $.ajax({  

	           url: "./my_source_codes/delete_driver.php?driver_id="+driver_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

                cache: false,  

                success: function(html){  

						$("#debug").html(html); 

                }  

            }); 

			ShowDrivers(<?php echo $_SESSION['company_id']?>);

}

function AddDriver(){

            $.ajax({  

	           url: "./my_source_codes/add_driver.php?user_id=<?php echo $_SESSION['user_id']?>

			   &company_id=<?php echo $_SESSION['company_id']?>"

			   +"&driver_name="+document.getElementById('driver_name').value

			   +"&driver_phone="+document.getElementById('driver_phone').value

			   , cache: false,  

                success: function(html){  

						$("#debug").html(html); 

                }  

            }); 

			ShowDrivers(<?php echo $_SESSION['company_id']?>);

	}

function submit_form(type_){

//alert(1);

	document.getElementById('order_type').value = type_;

	document.getElementById('OrderForm').submit();

/*	

alert(2);

	coords.splice(0, coords.length); 

	addresses = new Array();

alert(3);

	route=0;

	calcRoute();

alert(4);

	*/

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

    bookmark_activate('idMyOrders', "#MyOrders");

	return false;

}

function Cancel_Order(order_id_){

	alert(':-( не работает');

}







function Send_SMS(order_id_,phone_,message_,sender_){

	var phone = trim(phone_);

	phone = phone[1]+phone[3]+phone[4]+phone[5]+phone[7]+phone[8]+phone[9]+phone[11]+phone[12]+phone[14]+phone[15]





	$.post("./my_source_codes/sendsms_test.php", 

			{ company_id: <?php echo $_SESSION['company_id'] ?>, user_id: <?php echo $_SESSION['user_id'] ?>, order_id: order_id_},

  			function(html){

				$("#debug").html(html); 

			}, "xml");	

}







//	alert(phone);

//            $.ajax({  

//	           url: "./my_source_codes/sendsms.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>"

//			   +"&order_id="+order_id_

//			   +"&phone="+phone

//			   +"&message="+message_

//			   +"&sender="+sender_

//                ,cache: false,  

//                success: function(html){  

//						$("#debug").html(html); 

//                }  

//            }); 













function Client_to_Black_List(client_number_){

	$.post("./my_source_codes/add_client_black_list.php", 

			{ company_id: <?php echo $_SESSION['company_id'] ?>, user_id: <?php echo $_SESSION['user_id'] ?>, client_number: client_number_},

  			function(html){

    			$("#debug").html(html); 

  			},"xml");	

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

function SetDriverCar(order_id_){

	var   driver_set_id = document.getElementById('driver_set').value;

	var    order_status = document.getElementById('status_check').value;

//	alert(order_status);

	$.ajax({  

       url: "./my_source_codes/driver_set.php?order_id="+order_id_+"&driver_set_id="+driver_set_id+"&order_status="+order_status,  

          cache: false,  

          success: function(html){  

              $("#debug").html(html);  

        }  

     }); 

	show_my_orders();



	bookmark_activate('idMyOrders', "#MyOrders");

	return false;

}

function add_car_driver(order_id_){

	var driver_id=document.getElementById('driver_select').value;

	var car_id=document.getElementById('car_select').value;

	if (car_id>0){ 		

		if(driver_id>0){

			$.ajax({  

		       url: "./my_source_codes/driver_set.php?order_id="+order_id_+"&driver_set_id="+driver_set_id,  

			          cache: false,  

			          success: function(html){  

		              loadCasrByDrivers();  

		        }  

		     }); 

		}

	}

}

function check_black_list(){

	var phone = '+7('+trim(document.OrderForm.phone.value);

//	alert(phone);

	$.post("./my_source_codes/check_black_list.php", 

			{ company_id: <?php echo $_SESSION['company_id'] ?>, user_id: <?php echo $_SESSION['user_id'] ?>, client_number: phone},

  			function(html){

//				alert(length(html));

    			$("#black_list_div").html(html); 

  			}, 

		"html");		

}



function test(){

    var err=false;

	var phone = trim(document.OrderForm.phone.value);

	var err_msg = '';

    if (phone.length<10){	

	    err = true;

		err_msg = err_msg+' "Телефон клиента"';

	} 

	var price =    document.OrderForm.total_price.value;

	var distance = document.OrderForm.distance.value;

	if (distance/distance){

	}else{

	    err = true;

		err_msg = err_msg+' "Расстояние(км)" ';

	} 

    if (price/price){

	}else{	

	    err = true;

		err_msg = err_msg+' "Итого" ';

	} 

	if (err){

		err = true;

	    alert('Неверно заполнены следующие поля: '+err_msg);

	}

	return !err;

}

</script>

<?php

/*

function printClasses($company_id, $db){

	$classes_query =  ' SELECT tariff.Tariff_Min_Summa	AS min_sum_,

						car_classes.class_id		AS class_id_,

						car_classes.class_name	AS class_name_

					FROM tariff

					INNER JOIN Tariff_Min_Summa ON Tariff_Min_Summa != 0

					WHERE company_id = '.$company_id.' 

					ORDER BY class_id';

					

	$txt='';

	while ($line = mysql_fetch_array($classes_query, MYSQL_ASSOC)){

		$txt.= '<option value='.$line[class_id_].'>'.$line[class_name_].'</option>'; 

   }

   return 	$txt;						

*/

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

                  $("#Online").html(html);  

               }  

            });  

		}

		function loadHistory(filter_){

            $.ajax({  

               url: "./my_source_codes/print_history.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>&filter="+filter_,  

                cache: false,  

               success: function(html){  

                   $("#History").html(html);  

                }  

            });  

		}

		 function show_my_orders()  

        {  

           $.ajax({  

             url: "./my_source_codes/print_my_orders.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>",  

               cache: false,  

                success: function(html){  

                    $("#MyOrders").html(html);  

                }  

            });

       } 		

		 function loadNewOrder()  

        {  

            $.ajax({  

                url: "./my_source_codes/new_order.php",  

                cache: false,  

                success: function(html){  

                    $("#NewOrder").html(html);  

                }  

            }); 

			bookmark_activate('idNewOrder', "#NewOrder") 

        } 		

		 function new_fine()  

        {  

            $.ajax({  

               url: "./my_source_codes/new_fine.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>",  

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

			url: "./my_source_codes/load_balance.php?user_id=<?php echo $_SESSION['user_id']?>&company_id=<?php echo $_SESSION['company_id']?>",  

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

	function companies_online_list(){

		$.ajax({  

			url: "./my_source_codes/show_companies.php?company_id=<?php echo $_SESSION['company_id']?>",  

			cache: false,  

			success: function(html){  

				$("#companies_online").html(html);  

			}  

		});  	

	}	

	function black_list_company(){

		$.ajax({  

			url: "./my_source_codes/show_black_list_companies.php?company_id=<?php echo $_SESSION['company_id']?>",  

			cache: false,  

			success: function(html){  

//				$("#debug").html(html);  

				$("#black_list").html(html);  

			}  

		});  	

	}	

	function add_company_to_black_list(company_id_){

		$.ajax({  

			url: "./my_source_codes/add_company_to_black_list.php?closed_company="+company_id_+"&company_id=<?php echo $_SESSION['company_id']?>&user_id=<?php echo $_SESSION['user_id']?>",  

				  cache: false,  

				  success: function(html){  

						$("#debug").html(html); 

				  }  

		 }); 	

		 companies_online_list();

	};

	function delete_company_from_black_list(company_id_){

		$.ajax({  

			url: "./my_source_codes/delete_company_from_black_list.php?closed_company="+company_id_+"&company_id=<?php echo $_SESSION['company_id']?>&user_id=<?php echo $_SESSION['user_id']?>",  

				  cache: false,  

				  success: function(html){  

						$("#debug").html(html); 

				  }  

		 }); 	

		 black_list_company();

	};

	function print_fines_list(filter_){

		$.ajax({  

			url: "./my_source_codes/show_fines.php?company_id=<?php echo $_SESSION['company_id']?>&filter="+filter_,  

			cache: false,  

			success: function(html){  

				$("#fines_list").html(html);  

			}  

		});  	

	}	

	function edit_fine(fine_id_){

		$.ajax({  

			url: "./my_source_codes/edit_fine.php?fine_id="+fine_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

			cache: false,  

			success: function(html){  

				$("#edit_fine").html(html);  

			}  

		});  	

			$("ul.tabs2 li").removeClass("active");

			//document.getElementById('idEdit_Fine').addClass("active");

			$(".tab_content2").hide();

			var activeTab = "#edit_fine";

			$(activeTab).fadeIn();

	}	

	function agree_fine(fine_id_){

		$.ajax({  

			url: "./my_source_codes/fine_agree.php?fine_id="+fine_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

				  cache: false,  

				  success: function(html){  

						$("#debug").html(html); 

				  }  

		 }); 	

		print_fines_list(0);

		$("ul.tabs2 li").removeClass("active");

		$('#idFines_List').parent().addClass("active");

		$(".tab_content2").hide();

		var activeTab = "#fines_list";

		$(activeTab).fadeIn();

		return false;

	};

	function disagree_fine(fine_id_){

		$.ajax({  

			url: "./my_source_codes/fine_disagree.php?fine_id="+fine_id_+"&company_id=<?php echo $_SESSION['company_id']?>",  

				  cache: false,  

				  success: function(html){  

						$("#debug").html(html); 

				  }  

		 }); 	

		print_fines_list(0);

		$("ul.tabs2 li").removeClass("active");

		$('#idFines_List').parent().addClass("active");

		$(".tab_content2").hide();

		var activeTab = "#fines_list";

		$(activeTab).fadeIn();

		return false;

	};

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

			if ($(this).find("a").attr("href")=='#Online'){

				loadCasrByDrivers(<?php echo $_SESSION['company_id']?>);

			};

			if ($(this).find("a").attr("href")=='#NewOrder'){

				loadNewOrder();

			};

			if ($(this).find("a").attr("href")=='#History'){

				loadHistory(0);

			};

			if ($(this).find("a").attr("href")=='#Company'){

				ShowCompany(<?php echo $_SESSION['company_id']?>);

				show_settings();

			};

			if ($(this).find("a").attr("href")=='#Fine'){

				new_fine(<?php echo $_SESSION['company_id']?>);

			};

			if ($(this).find("a").attr("href")=='#Cars'){

				ShowCars(<?php echo $_SESSION['company_id']?>);

			};

			if ($(this).find("a").attr("href")=='#Drivers'){

				ShowDrivers(<?php echo $_SESSION['company_id']?>);

			};

			if ($(this).find("a").attr("href")=='#Clients'){

				ShowClients();

			};

			return false;

		});

		$("ul.tabs2 li").click(function() {

				// обработка нажатий закладок в правой части

			$("ul.tabs2 li").removeClass("active");

			$(this).addClass("active"); //добавить класс "active" к выбраной вкладке

			$(".tab_content2").hide(); //Скрыть вкладку и ее содержание

			var activeTab = $(this).find("a").attr("href"); //Найти значение атрибута для выявления активной вкладки с содержанием

			$(activeTab).fadeIn(); //

			if ($(this).find("a").attr("href")=='#hidden_orders'){

				print_hidden_orders();

			};

			if ($(this).find("a").attr("href")=='#fines_list'){

				print_fines_list(0);

			};

			if ($(this).find("a").attr("href")=='#companies_online'){

				companies_online_list();

			};

			if ($(this).find("a").attr("href")=='#black_list'){

				black_list_company();

			};

		});

		$("#settings_tabs li a").click(function() {

			$("#settings_tabs li").removeClass("active");

			$(this).parent("li").addClass("active"); //добавить класс "active" к выбраной вкладке

			//$(".tab_content").hide(); //Скрыть вкладку и ее содержание			

			

			var activeTab = '#' + $(this).attr("id");

			if (activeTab=='#Online'){

				loadCasrByDrivers(<?php echo $_SESSION['company_id']?>);

			};

			if (activeTab=='#NewOrder'){

				loadNewOrder();

			};

			if (activeTab=='#History'){

				loadHistory(0);

			};

			if (activeTab=='#idCompany'){

				ShowCompany(<?php echo $_SESSION['company_id']?>);

			};

			if (activeTab=='#idTarifs'){

				ShowTarifs(<?php echo $_SESSION['company_id']?>);

			};			

			if (activeTab=='#idCars'){

				ShowCars(<?php echo $_SESSION['company_id']?>);

			};

			if (activeTab=='#idDrivers'){

				ShowDrivers(<?php echo $_SESSION['company_id']?>);

			};

			if (activeTab=='#idClients'){

				ShowClients();

			};

			

			return false;

		

		});

	});		

	function setStreet(num_, street_){

		$.post("./my_source_codes/set_street.php", { user_id: "<?php echo $_SESSION['user_id'] ?>", num: num_, street: street_},

  			function(html){

    			$("#debug").html(html); 

  			}, 

		"xml");	

	}

// обработка автозаполнения в разных полях



	function and_back(){

		$.ajax({  

			url: "./my_source_codes/and_back.php?sid=<?php echo session_id();?>",  

				  cache: false,  

				  success: function(html){  

						$("#debug").html(html); 

						showRoute();

				  }  

		 }); 		

	}

	

    function add_point(num){

		$.post("./my_source_codes/add_adr.php", 

			{ str: document.getElementById('adr_street'+num).value, house: document.getElementById('adr_domkorp'+num).value, adr_porch: document.getElementById('adr_porch'+num).value, shir: point[1], dolg: point[0], sid:"<?php echo session_id();?>", sort_: num},

  			function(html){

				//alert(html.length);

    			$("#debug2").html(html); 

 			}, 

		"html");	

			

 		showRoute();

	/*	document.getElementById('adr_street'+num).value=''; 

		document.getElementById('adr_domkorp'+num).value=''; 

		document.getElementById('adr_porch'+num).value='';*/

	}

	function showPoint(num){

		bookmark_activate('idMap', "#Map");



		if ((point[0]>0)&&(point[1]>0)&&(coords.length<1)){

			myMap.geoObjects.remove(myPlacemark);

			myPlacemark = new ymaps.Placemark([point[1], point[0]],

				{

					iconContent: document.getElementById('adr_street'+num).value+ ' '+document.getElementById('adr_domkorp'+num).value,

					balloonContentHeader: '',

					balloonContentBody: document.getElementById('adr_street'+num).value+ ' '+document.getElementById('adr_domkorp'+num).value,

				},

				{preset: 'twirl#blueStretchyIcon'}

			);

			myMap.geoObjects.add(myPlacemark);

			myMap.setCenter([point[1], point[0]], 15);

		}

	}

	

		function showPoint2(num){

		bookmark_activate('idMap', "#Map");

	//	alert(2);

		if ((coords[num][0]>0)&&(coords[num][1]>0)){

		//	alert(3);

			myMap.geoObjects.remove(myPlacemark);

			myPlacemark = new ymaps.Placemark([coords[num][1], coords[num][0]],

				{

					iconContent: document.getElementById('adr_street'+num).value+ ' '+document.getElementById('adr_domkorp'+num).value,

					balloonContentHeader: '',

					balloonContentBody: document.getElementById('adr_street'+num).value+ ' '+document.getElementById('adr_domkorp'+num).value,

				},

				{preset: 'twirl#blueStretchyIcon'}

			);

			myMap.geoObjects.add(myPlacemark);

			myMap.setCenter([coords[num][1], coords[num][0]], 15);

		}

	}

	

	

	

	function calcPrice(){

		var RouteLength = document.getElementById('distance').value; 

		RoutePrice = RouteLength * 35; 

		RoutePrice = Math.round(RoutePrice/5);

		document.getElementById('price').value = RoutePrice*5; 

		calcDiscount();

	}

	

	function calcDiscount(){

		var RoutePrice = document.getElementById('price').value; 

		var RouteDiscount = document.getElementById('discount').value; 

		if (RouteDiscount>0){

		}else{

			RouteDiscount=0;

		}

		TotalPrice = Math.round(RoutePrice*(100-RouteDiscount)/100/5);

		document.getElementById('total_price').value = TotalPrice*5; 

	}

	

	function calcRoute(){

		if (coords.length>=2){

//			myMap.removeAllOverlays();

			try{

				myMap.geoObjects.remove(myPlacemark);

			}catch(e){

			}	

			str = new Array(coords.length);

			var geo=[];

			for(var i=0; i<coords.length; i++){

				str[i]=[coords[i][1], coords[i][0]];

			}

            myRoute = ymaps.route(

					str,

					{

               mapStateAutoApply: true, avoidTrafficJams:true // автоматически позиционировать карту

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

	//		bookmark_activate('idMap', "#Map");

		}else{

			if (coords.length==0){

				myMap.geoObjects.remove(route);

			}	

		}

	}

	ymaps.ready(init);



	$(document).ready(function(){  

       //  showRoute();

		// calcRoute();

    });

	

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

	}

	function showRoute(){

	  $.ajax({  

			url: "./my_source_codes/print_route.php?sid=<?php echo session_id();?>&user_id=<?php echo $_SESSION['user_id']; ?>",

			cache: false,  

			success: function(html){  

				$("#adr_conteiner").html(html); 

				calcRoute(); 

			}  

		});

	}

	function show_new_call(phone_){

	

	  $.ajax({  

			url: "./my_source_codes/show_new_call.php?phone="+phone_,

			cache: false,  

			success: function(html){  

				$("#top_new_calls").append(html);

				

			}  

		});	  

	}

function show_phone(){

	$.ajax({  

          url: "http://vtsystem.ru/ast/get_phone2.php",  

          cache: false,  

          success: function(html){

		  

			if (html != "-") {

				if($("#" + html).length == 0) {

					show_new_call(html);

				}

			}

			$("#debug2").append(html);	

			$("#debug").append(html);	

          }  

    });

	return false;

}



    $(document).ready(function(){  

	    setInterval('show_phone()',3000);  

    });

	

function show_settings(){

		$("#input_routes").hide();

		$("#settings").show();

}	

        $(document).ready(function(){  

		$("#idul1 li a").click(function(){

		    $("#input_routes").show();

		    $("#settings").hide();

		    });  	

        });

function add_tarif(id_){



	var $id = id_,

	 $car_class_id = $id,

	 $min_sum = $("#new_min_sum").val(),

	 $min_km = $("#new_min_km").val(),

	 $base_price = $("#new_base_price").val();



            $.ajax({  

	           url: "./my_source_codes/add_tarif.php?user_id=<?php echo $_SESSION['user_id']?>

			   &company_id=<?php echo $_SESSION['company_id']?>"

			   +"&car_class_id="+$car_class_id

			   +"&min_sum="+$min_sum

			   +"&min_km="+$min_km

			   +"&base_price="+$base_price

			   , cache: false,  

                success: function(html){

	       // Выводим обновленные данные с новым списком еще не добавленных классов авто

	       ShowCompany(<?php echo $_SESSION['company_id']?>);

				

                }  

            }); 

}		

function edit_tarif(id_,field_){



	var $id = id_,

	 $car_class_id = $id,

	 $min_sum = $("#min_sum"+$id).val(),

	 $min_km = $("#min_km"+$id).val(),

	 $base_price = $("#base_price"+$id).val();

	$field = "#"+field_;



            $.ajax({  

	           url: "./my_source_codes/edit_tarif.php?user_id=<?php echo $_SESSION['user_id']?>

			   &company_id=<?php echo $_SESSION['company_id']?>"

			   +"&tarif_id="+$id

			   +"&car_class_id="+$car_class_id

			   +"&min_sum="+$min_sum

			   +"&min_km="+$min_km

			   +"&base_price="+$base_price

			   , cache: false,  

                success: function(html){

				//alert(html);

				$($field).css("background-color","#caeaf4");

                }  

            }); 

}	

function del_tarif(car_class_id_){



            $.ajax({  

	           url: "./my_source_codes/del_tarif.php?company_id=<?php echo $_SESSION['company_id']?>"

			   +"&car_class_id="+car_class_id_

			   , cache: false,  

                success: function(html){

	       // Выводим обновленные данные

	       ShowCompany(<?php echo $_SESSION['company_id']?>);

				

                }  

            }); 

}	





function default_car_class(class_id_){



            $.ajax({  

	           url: "./my_source_codes/default_car_class.php?company_id=<?php echo $_SESSION['company_id']?>"

			   +"&default_car_class="+class_id_

			   , cache: false,  

                success: function(html){

				//alert(html);

                }  

            }); 

}	



</script>

<?php $left_half_wid = 700; 

	  $left_half_hei = 500; 

?>

	<table id="area_table">

	<tr>

		<td id="left_side" valign="top">

			

			<ul class="tabs" id="idul1">

				<li><a href="#MyOrders"	 	id="idMyOrders">Активные</a></li>

				<li><a href="#History"	id="idHistory">История</a></li>

				<li><a href="#Online" 	id="idOnline">На линии</a></li>

				<li><a href="#Map" 		id="idMap">Карта</a></li>

				<li><a href="#Company" 	id="idCompany">Настройки</a></li>

			</ul>

			

			<form id="OrderForm" name="OrderForm" method="post" onSubmit="return test();" action="./index.php?option=com_content&view=article&id=56&Itemid=51&addpar=orders&act=add">

			<div id="top_left_container">	

	<!-- Административная часть -->	

				<div id="settings" style="display: none;">

				     <ul id="settings_tabs" class="tabs">

					<li><a href="#" 	id="idCompany">О Компании</a></li>

					<li><a href="#" 	id="idTarifs">Тарифы</a></li>

					<li><a href="#" 	id="idSMS">SMS</a></li>

					<li><a href="#" 	id="idDispetchers">Диспетчеры</a></li>

					<li><a href="#" 	id="idDrivers">Водители</a></li>

					<li><a href="#" 	id="idCars">Автомобили</a></li>

					<li><a href="#" 	id="idClients">Клиенты</a></li>

				     </ul>

				  </div>

	<!--    -->			

			    <div id="input_routes">

				<table id="input_routes_table">

				 <tr>

				  <th>Время</th>

				  <td style=" white-space:nowrap;">

				   <input type="text"  name="time_pod"  id="time_pod" size="9" value="<?php echo fillDefTime($_POST['time_pod']) ?>" onclick="return showCalendar('time_pod', 'y-mm-dd');"/>

				   <select name="time_pod_hours" id="time_pod_hours" >

				    <?php echo printHours($_POST['time_pod_hours']) ?>

				   </select>:

				   <select name="time_pod_min" id="time_pod_min" >

				    <?php echo printMinutes($_POST['time_pod_min']) ?>

				   </select>						

				  </td>

				  <th>Класс</th>

				  <td>

				   <select name="class_auto" id="class_auto"> <?php echo printClasses(1, $db) ?> </select>

				  </td>

				  <th style=" white-space:nowrap;">В пути</th>

				   <td><input type="text" size="5" id="HumanJamsTime" name ="HumanJamsTime" /></td>

				  <td>мин.</td>

	

				  <td rowspan="2">

				   <table id="input_order_table">

				    <tr>

				     <th><a href="#" onclick="calcRoute();  return false">Расстояние</a></th>

				     <td>

				      <input type="hidden" id="sid" name="sid" value="<?php echo session_id();?>"  />

				      <input type="text" size="5" id="distance" name ="distance" onchange="calcPrice()"/> 	

				     </td>

				     

				     <th>км.</th>

				    </tr>

				    <tr>			     

				     <th>Стоимость</th>

				     <td><input type="text" size="5" id="price" name="price" onchange="calcDiscount();"/></td>

				     <th>руб.</th>

				    </tr>

				    <tr>

				     <th>Скидка</th>

				     <td><input type="text" size="5" id="discount" name="discount" placeholder="Скидка" onchange="calcDiscount()" value="0"/></td>

				     <th>%</th>

				    </tr>

				    <tr>

				     <th style="border-bottom: 1px solid #098BB4;">Итого</th>

				     <td><input type="text" size="5" id="total_price" name="total_price" placeholder="Итого"/></td>

				     <th style="border-bottom: 1px solid #098BB4;">руб.</th>

				    </tr>

				    <tr><td colspan="3" height="5" style="border: none;"></td></tr>

				    <tr>

				     <td colspan="3" style="border: 0;padding:0;"><span id="idNewOrder" class="button" href="#" onclick="loadNewOrder(); return false;">Оформить заказ</span></td>

				    </tr>				    

				   </table>

				  </td>			  

				 </tr>

				 <tr>

				  <td colspan="7" valign="top">

				   <span id="adr_conteiner">

				   </span>

				   <br/>	

				   <a href="#" onclick="and_back(); return false;"> и обратно</a>	

				  </td>

	

				 </tr>

				</table>

			   </div>

			    

			</div>

	

			

			<div class="tab_container">

				<div id="MyOrders" class="tab_content"></div>		

				<div id="NewOrder" class="tab_content"></div>

				<div id="History" class="tab_content"></div>

				<div id="Online" class="tab_content"></div>

				<div id="tab5" class="tab_content"></div>

				<div id="cont5" class="show_divs"></div>

				<div id="Map" class="tab_content">

					<div id="cont7" class="show_divs" style="width: <? echo $left_half_wid-20 ?>px; height: <? echo $left_half_hei-20 ?>px"></div>

				</div>

				<div id="Fine" class="tab_content"></div>				

				

			<!-- Административная часть -->	

				<div id="Company" class="tab_content"></div>

				<div id="Tarifs" class="tab_content"></div>

				<div id="Cars" class="tab_content"></div>

				<div id="Drivers" class="tab_content"></div>

				<div id="Clients" class="tab_content"></div>

			<!--    -->	

			</div>



		</form>

			

			

		</td>

		<td id="right_side" valign="top">

				<ul class="tabs2" id="idul2">

					<li><a href="#stock"				id="idStock">Площадка</a></li>

					<li><a href="#hidden_orders"   	id="idHidden">Скрытые заказы</a></li>

					<li><a href="#companies_online" 	id="idCompOnLine">Компании On-Line</a></li>

					<li><a href="#black_list" 			id="idBlackList">Черный список</a></li>

					<li><a href="#fines_list" 			id="idFines_List">Претензии</a></li>

				</ul>

			<div class="tab_container">	

				<div id="stock" class="tab_content2">

					<div class="componentheading"></div>

					<div id="order_conteiner" > </div>  	

					<div id="debugggg" name="debug" >debug </div> 

					<div id="debugggg2" name="debug2" >debug2 </div> 

				</div>	

				<div id="hidden_orders" class="tab_content2" >

					Скрытые заказы

				</div>

				<div id="companies_online" class="tab_content2">

					Компании On-Line

				</div>

				<div id="black_list" class="tab_content2">

					Черный список

				</div>

				<div id="fines_list" class="tab_content2">

				</div>

				<div id="edit_fine" class="tab_content2">

				</div>

			</div> 	 	

		</td> 

		</tr>

</table>

