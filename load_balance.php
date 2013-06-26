<?php 
	
	include_once('db_ini.php');

    $company_id_ = $_GET['company_id'];
    $user_id_ = $_GET['user_id'];
    $user_group_ = $_GET['user_group'];
	
	if ($user_id_>0){
		
	$user_name= ' SELECT companies.company_name, jos_users.name, companies.test_period_to'.
							' FROM jos_users '. 
							' INNER JOIN companies ON companies.company_id = jos_users.company_id'.
							' WHERE id = '.$user_id_;
						
		$res_user_name = mysql_query($user_name);
		$test_period_to_ = mysql_result($res_user_name, 0,2);
		if (mysql_num_rows($res_user_name)==1){
			echo 'Компания: '.mysql_result($res_user_name, 0,0);
			echo '<br>';
			echo 'ФИО: '.mysql_result($res_user_name, 0,1);
			echo '<br>';
		//	echo 'Тестовый период до : ' .$test_period_to_;
		//	echo '<br>';
			$dt=date('Y-m-d');
			echo "Текущая дата и время на сервере: $dt";
			echo '<br>';
			
		/*	if ($dt < $test_period_to_){
				$test_period_to_ = strtotime($test_period_to_);
				$dt = strtotime("now");
				$days = ($test_period_to_ - $dt)/ (60*60*24);
				$round_days = round($days);
				echo 'До окончания тестового периода осталось: '.$round_days.' ';	
				if ($round_days == 1){
					echo 'день.';
				} else
				if ($round_days == 2 or $round_days == 3 or $round_days == 4){
					echo 'дня.';
				} else{
					echo 'дней.';
				};
				echo '<br>';
			}
		*/
		}		
		
		$q_=' SELECT all_sum FROM companies WHERE company_id = '.$company_id_;
		$results = mysql_query($q_);
		// Показываем баланс только Пользователям(Диспетчеры не видят)
		echo ($user_group_ == 1) ? 'Баланс:  '.mysql_result($results, 0, 0).' руб.' : '';
	}
?>