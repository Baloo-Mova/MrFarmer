<?PHP
$_OPTIMIZATION["title"] = "Восстановление пароля";
$_OPTIMIZATION["description"] = "Восстановление забытого пароля";
$_OPTIMIZATION["keywords"] = "Восстановление забытого пароля";

if(isset($_SESSION["user_id"])){ Header("Location: /account"); return; }

?>
<div class="text_right">
<div class="container_down">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div style="padding-top:0px;" class="text">

<?PHP
	if(isset($_POST["submit"])){
		$email = $func->IsMail($_POST["email"]);
		$login = $func->IsLogin($_POST["login"]);
		$time = time();
		$tdel = $time + 60*30;
		
		$new_password = substr(md5(time()), 0, 7);
		$new_pass = $func->md5Password($new_password);
		
	if($email !== false || $login !== false){
		if($email !== false && $login !== false) {
			$db->Query("DELETE FROM `db_recovery` WHERE `date_del` < '$time'");
			$db->Query("SELECT COUNT(*) FROM `db_recovery` WHERE `ip` = INET_ATON('".$func->UserIP."') OR `email` = '$email' OR `user` = '$login'");
			if($db->FetchRow() == 0){
				$db->Query("SELECT `id`, `user`, `email`, `pass` FROM `db_users_a` WHERE `email` = '$email' AND `user` = '$login'");
				if($db->NumRows() == 1){
				$db_q = $db->FetchArray();
				$db->Query("INSERT INTO `db_recovery` (`user`, `email`, `ip`, `date_add`, `date_del`) VALUES ('$login', '$email',INET_ATON('".$func->UserIP."'),'$time','$tdel')");
				$db->Query("UPDATE `db_users_a` SET `pass` = '$new_pass' WHERE `email` = '$email'");
					$sender = new isender;
					$sender -> RecoveryPassword($db_q['user'], $new_password, $db_q['email']);
					echo "<div class='ok'>Данные для входа отправлены на Email</div>";
				} else echo "<div class='err'>Ошибка! Пользователь не найден!</div>";
			} else echo "<div class='err'>Вы можете повторить операцию не чаще чем 1 раз в 30 минут!</div>";
		}
		elseif($email !== false && $login === false) {
			$db->Query("DELETE FROM `db_recovery` WHERE `date_del` < '$time'");
			$db->Query("SELECT COUNT(*) FROM `db_recovery` WHERE `ip` = INET_ATON('".$func->UserIP."') OR `email` = '$email'");
			if($db->FetchRow() == 0){
				$db->Query("SELECT `id`, `user`, `email`, `pass` FROM `db_users_a` WHERE `email` = '$email'");
				if($db->NumRows() == 1){
				$db_q = $db->FetchArray();
				$db->Query("INSERT INTO `db_recovery` (`email`, `ip`, `date_add`, `date_del`) VALUES ('$email',INET_ATON('".$func->UserIP."'),'$time','$tdel')");
				$db->Query("UPDATE `db_users_a` SET `pass` = '$new_pass' WHERE `email` = '$email'");
					$sender = new isender;
					$sender -> RecoveryPassword($db_q['user'], $new_password, $db_q['email']);
					echo "<div class='ok'>Данные для входа отправлены на Email</div>";
				} else echo "<div class='err'>Ошибка! Пользователь не найден!</div>";
			} else echo "<div class='err'>Вы можете повторить операцию не чаще чем 1 раз в 30 минут!</div>";
		}
		elseif($email === false && $login !== false) {
			$db->Query("DELETE FROM `db_recovery` WHERE `date_del` < '$time'");
			$db->Query("SELECT COUNT(*) FROM `db_recovery` WHERE `ip` = INET_ATON('".$func->UserIP."') OR `user` = '$login'");
			if($db->FetchRow() == 0){
				$db->Query("SELECT `id`, `user`, `email`, `pass` FROM `db_users_a` WHERE `user` = '$login'");
				if($db->NumRows() == 1){
				$db_q = $db->FetchArray();
				$db->Query("INSERT INTO `db_recovery` (`user`, `ip`, `date_add`, `date_del`) VALUES ('$login', INET_ATON('".$func->UserIP."'),'$time','$tdel')");
				$db->Query("UPDATE `db_users_a` SET `pass` = '$new_pass' WHERE `user` = '$login'");
					$sender = new isender;
					$sender -> RecoveryPassword($db_q['user'], $new_password, $db_q['email']);
					echo "<div class='ok'>Данные для входа отправлены на Email</div>";
				} else echo "<div class='err'>Ошибка! Пользователь не найден!</div>";
			} else echo "<div class='err'>Вы можете повторить операцию не чаще чем 1 раз в 30 минут!</div>";
		}
	}else echo "<div class='err'>Данные указаны неверно!</div>";
 } 
 
	if(isset($_POST["loginform"])){
		$lmail = $func->IsMail($_POST["email"]);
		$login = $func->IsLogin($_POST["login"]);
		if($login !== false){
		if($lmail !== false){
			$db->Query("SELECT `id`, `user`, `pass`, `referer_id`, `banned` FROM `db_users_a` WHERE `email` = '$lmail' AND `user` = '$login'");
			if($db->NumRows() == 1){
			
			$log_data = $db->FetchArray();
			
				$pass = $func->md5Password($_POST["pass"]);
				if($log_data["pass"] == $pass){
				
					if($log_data["banned"] == 0){
						
						# Считаем рефералов
						$db->Query("SELECT COUNT(*) FROM `db_users_a` WHERE `referer_id` = '".$log_data["id"]."'");
						$refs = $db->FetchRow();
						
						$db->Query("UPDATE `db_users_a` SET `referals` = '$refs', `date_login` = '".time()."', `ip` = INET_ATON('".$func->UserIP."') WHERE `id` = '".$log_data["id"]."'");
						
						$_SESSION["user_id"] = $log_data["id"];
						$_SESSION["user"] = $log_data["user"];
						$_SESSION["referer_id"] = $log_data["referer_id"];
						Header("Location: /account.html");
						
		}else echo "<div class='err'>Аккаунт заблокирован</div>";
		}else echo "<div class='err'>Пароль указан неверно</div>";
		}else echo "<div class='err'>Указанный пользователь не зарегистрирован в системе</div>";
		}else echo "<div class='err'>Email указан неверно</div>";
		}else echo "<div class='err'>Логин указан неверно</div>";
	}

?>


	<div class="narrow">
		<div class="title_r">Смена пароля</div>
		<div class="top_title">Пожалуйста, введите свой почтовый ящик или пользовательское имя, для получения нового пароля</div>  
		<div class="s_divide"></div>
		<form method="post" action="">
			<input type="text" placeholder="Пользователь" class="input_text w340" value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" name="login"/>
			<div class="or">или </div>
			<input type="text" placeholder="E-mail" class="input_text w340" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>" name="email"/>
			<input type="submit" class="subm_button" value="Смена пароля" name="submit"/>
		</form>    
	</div>   
	<div class="narrow_r">
		<div class="title_r">Вход</div>
		<form name="loginform" action="/signup.html" method="post">
			<input name="login" type="text" value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" placeholder="Пользователь" class="input_text"/> 
			<input name="email" type="text" placeholder="E-mail" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>" class="input_text"/>
			<input name="pass" type="password" placeholder="Пароль" class="input_text"/>
		<div class="clear"></div>
			<input type="submit" class="subm_button" value="Вход" name="loginform"/>
		</form>
	</div>
</div>

</div>
<div class="text_pages_bottom"></div>
</div>
</div>