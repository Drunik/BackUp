<?php 



	function prepNumber($value_){



		return str_replace(",", ".", $value_);



	}



	



	include_once('db_ini.php');





    $company_id_ = $_GET['company_id'];



	$order_id_ = $_GET['order_id'];



	



 //   $query=' UPDATE taxi3_orders SET status = 1, finished = 1 WHERE taxi3_orders.order_id = '.$_GET['order_id'];



	$q_=' SELECT type, Price, rate, customer_id, company_id, start_rate FROM taxi3_orders WHERE taxi3_orders.order_id = '.$order_id_;



	$results = mysql_query($q_);



	if (mysql_num_rows($results)>0){

		if(mysql_result($results, 0, 0)==1){				// проверка типа заказа если свой

			$query=' UPDATE taxi3_orders SET status = 1, finished = 1 WHERE taxi3_orders.order_id = '.$order_id_;

			$res_order = mysql_query($query);

		}else{												// проверка типа заказа если купленный

			$Price = mysql_result($results, 0, 1);

			$rate = mysql_result($results, 0, 2);

			$LastRate = mysql_result($results, 0, 2); 				//временно до введения начальной и конечной ставки 

			$FirstRate = mysql_result($results, 0, 5);

			$company_id = mysql_result($results, 0, 4);

			$customer_id = mysql_result($results, 0, 3);

			$q_company = 'SELECT tarif FROM companies WHERE company_id = '.$company_id;

			$results_company = mysql_query($q_company);

			$tarif = mysql_result($results_company, 0, 0);

			$OrderSystem=0;

			$OrderHolder=0;

			$OrderExecutive=0;		



			switch ($tarif) {



				case 1:

					$OrderSystem = $Price*0.005*+$Price*($LastRate- $FirstRate)*0.004;
					$OrderExecutive = $Price*$LastRate/100;
					$OrderHolder = $OrderExecutive - $OrderSystem;	
					break;



				case 2:	

					if ($LastRate>$FirstRate){

						$OrderSystem = 0.025*$Price;

					}else{

						$OrderSystem = 0.005*$Price;

					}

					$OrderExecutive = $Price*$LastRate/100;

					$OrderHolder = $OrderExecutive - $OrderSystem;	

					break;



				case 3:

					$OrderSystem = $Price*($LastRate- $FirstRate)*0.003;

					$OrderExecutive = $Price*$LastRate/100;

					$OrderHolder = $OrderExecutive - $OrderSystem;	

					break;



				case 4:

					$OrderSystem = 0;

					$OrderExecutive = $Price*$LastRate/100;

					$OrderHolder = $OrderExecutive - $OrderSystem;	

					break;



				case 5:

					$OrderSystem = 12.5;

					$OrderExecutive = $rate/100*$Price;

					$OrderHolder = $OrderExecutive - $OrderSystem;	

					break;

			}



					mysql_query("SET AUTOCOMMIT=0");

					mysql_query("START TRANSACTION");



			// вычитаем у покупателя



		   			$res1= mysql_query(' INSERT INTO money_orders (company, order_id, summa, comment, type ) VALUES('.$customer_id.','.$order_id_.','.	



					'-'.prepNumber($OrderExecutive).',"Списание за покупку заказа №'.$order_id_.'", 1); ');					



					



			// добавляем продавцу



				    $res2= mysql_query(' INSERT INTO money_orders (company, order_id, summa, comment, type, tarif) VALUES('.$company_id.','.$order_id_.','.	



					prepNumber($OrderHolder).',"Начисление за продажу заказа №'.$order_id_.'", 1,"Тарифный план - '.$tarif.'"); ');



			// добавляем системе		



				    $res3= mysql_query(' INSERT INTO money_orders (company, order_id, summa, comment, type, tarif) VALUES(0,'.$order_id_.','.		



					prepNumber($OrderSystem).',"Комиссия системы, заказ №'.$order_id_.'", 1,"Тарифный план - '.$tarif.'"); ');



			// временно вычитаем у системы		



				    $res4= mysql_query(' INSERT INTO money_orders (company, order_id, summa, comment, type, tarif) VALUES(0,'.$order_id_.','.		



					'-'.prepNumber($OrderSystem).',"Врем. возврат комиссии, заказ №'.$order_id_.'", 1,"Тарифный план - '.$tarif.'"); ');



			// временно добавляем продавцу		



				    $res5= mysql_query(' INSERT INTO money_orders (company, order_id, summa, comment, type, tarif) VALUES('.$company_id.','.$order_id_.','.		



					prepNumber($OrderSystem).',"Врем. начисление за продажу заказа №'.$order_id_.'", 1,"Тарифный план - '.$tarif.'"); ');



					



					$res6= mysql_query(' UPDATE companies SET all_sum = all_sum + '.prepNumber($OrderHolder).' WHERE company_id = '.$company_id.' ;');



					$res7= mysql_query(' UPDATE companies SET all_sum = all_sum - '.prepNumber($OrderExecutive).' WHERE company_id = '.$customer_id.' ;');



					$res8= mysql_query(' UPDATE companies SET all_sum = all_sum + '.prepNumber($OrderSystem).' WHERE company_id = 0 ;');



					$res9= mysql_query(' UPDATE companies SET all_sum = all_sum + '.prepNumber($OrderSystem).' WHERE company_id = '.$customer_id.' ;');		// временные действия



					$res10= mysql_query(' UPDATE companies SET all_sum = all_sum - '.prepNumber($OrderSystem).' WHERE company_id = 0 ;');



		   			$res11= mysql_query(' UPDATE taxi3_orders SET status = 1, finished = 1 WHERE order_id = '.$order_id_.';');



					if ($res1&$res2&$res3&$res4&$res5&$res6&$res7&$res8&$res9&$res10&$res10){



						mysql_query("COMMIT");



					}else{



						mysql_query("ROLLBACK");



					}



					mysql_query("SET AUTOCOMMIT=1");



		//	echo $query;



		//	$res_order = mysql_query($query);



		}



	}







	



	echo '<BR>'.$res_order;



	



	



?>





