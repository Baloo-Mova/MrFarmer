<?PHP
$_OPTIMIZATION["title"] = "�����������";
$_OPTIMIZATION["description"] = "����������� ������������ � �������";
$_OPTIMIZATION["keywords"] = "����������� ������ ��������� � �������";

if(isset($_SESSION["user_id"])){ Header("Location: /account"); return; }
$referer_id = (isset($_COOKIE["i"]) AND intval($_COOKIE["i"]) > 0 AND intval($_COOKIE["i"]) < 1000000) ? intval($_COOKIE["i"]) : 1;
	$db->Query("SELECT * FROM `db_users_a` WHERE `id` = '$referer_id'");
	if ($db->Numrows() > 0){
		$r = $db->FetchArray();
		$referer_name = $r["user"];
	} else {
		$referer_name = 'admin';
		$referer_id = 1;
	}
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>
	<div class="text" style="padding-top:0px;">
<?PHP
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
						
						# ������� ���������
						$db->Query("SELECT COUNT(*) FROM `db_users_a` WHERE `referer_id` = '".$log_data["id"]."'");
						$refs = $db->FetchRow();
						
						$db->Query("UPDATE `db_users_a` SET `referals` = '$refs', `date_login` = '".time()."', `ip` = INET_ATON('".$func->UserIP."') WHERE `id` = '".$log_data["id"]."'");
						
						$_SESSION["user_id"] = $log_data["id"];
						$_SESSION["user"] = $log_data["user"];
						$_SESSION["referer_id"] = $log_data["referer_id"];
						Header("Location: /account.html");
						
		}else echo "<div class='err'>������� ������������</div>";
		}else echo "<div class='err'>������ ������ �������</div>";
		}else echo "<div class='err'>��������� ������������ �� ��������������� � �������</div>";
		}else echo "<div class='err'>Email ������ �������</div>";
		}else echo "<div class='err'>����� ������ �������</div>";
	}

?>
<?php	
	if(isset($_POST["singup"])){
	$login = $func->IsLogin($_POST["login"]);
	$pass = $func->IsPassword($_POST["password"]);
	$rules = isset($_POST["rules"]) ? true : false;
	$time = time();
	$ip = $func->UserIP;
	$ipregs = $db->Query("SELECT * FROM `db_users_a` WHERE INET_NTOA(db_users_a.ip) = '$ip' ");
	$ipregs = $db->NumRows();
	$passmd = $func->md5Password($pass);

	$email = $func->IsMail($_POST["email"]);
	
		if($rules){
		if($ipregs == 0) {
			if($login !== false){
			if($email !== false){
		
				if($pass !== false){
			
					if($pass == $_POST["re_password"]){
					
						//$db->Query("SELECT COUNT(*) FROM `db_users_a` WHERE `ip` = '$ipp'");
						//if($db->FetchRow() == 0){
						
						$db->Query("SELECT COUNT(*) FROM `db_users_a` WHERE `user` = '$login' AND `email` = '$email'");
						if($db->FetchRow() == 0){
						
						# ������ ������������ + ����� ��� ����
						$db->Query("INSERT INTO `db_users_a` (`user`, `email`, `pass`, `referer`, `referer_id`, `date_reg`, `ip`) 
						VALUES ('$login','$email','$passmd','$referer_name','$referer_id','$time',INET_ATON('$ip'))");
						
						$lid = $db->LastInsert();
                        $db->Query("INSERT INTO `db_users_b` (`id`, `user`, `money_b`)  VALUES ('$lid', '$login', '100')"); 

						# ��������� ����������
						$db->Query("UPDATE `db_stats` SET `all_users` = all_users + 1 WHERE `id` = '1'");
						
						# ����������
						$sender = new isender;
						$sender -> SendAfterReg($login, $email, $pass);	
						
						echo "<div class='ok'>�� ������� ������������������!</div>";
				}else echo "<div class='err'>������ ������������ ��� ���������� ��� � ����� ip ��� ���� �����������!</div>";
				}else echo "<div class='err'>������ � ������ ������ �� ���������!</div>";
				}else echo "<div class='err'>������ �������� �������!</div>";
				}else echo "<div class='err'>E-mail �������� �������!</div>";
				}else echo "<div class='err'>����� �������� �������!</div>";
				}else echo "<div class='err'>������ ������������ ��� ���������� ��� � ����� ip ��� ���� �����������!</div>";
				}else echo "<div class='err'>�� �� ����������� �������!</div>";

	}
?>

<div class="narrow">
<div class="title_r">����</div>
<form name="loginform" action="/signup.html" method="post">
<input name="login" type="text" value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" placeholder="������������" class="input_text"/> 
<input name="email" type="text" placeholder="E-mail" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>" class="input_text"/>
<input name="pass" type="password" placeholder="������" class="input_text"/>
<div class="clear"></div>
<input type="submit" class="subm_button" value="����" name="loginform">
</form>
<div class="terms_main">
<label for="terms"><a href="/recovery.html">������ ������?</a></label>
</div>
</div>



<div class="narrow_r">
<div class="title_r">�����������</div>
<form name="singup" method="post" action="/signup.html">
<input type="text" placeholder="������������"  value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" name="login" class="input_text"/>
<input type="text" placeholder="E-mail" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>"/ name="email" class="input_text"/>
<input type="password" placeholder="������" value="" name="password" class="input_text"/>
<input type="password" placeholder="����������� ������" value="" name="re_password" class="input_text"/>
<div class="clear"></div>
<div class="terms_main">
<input type="checkbox" name="rules"/> <label for="terms">� �������� � ���������� � <a href="/rules" target="_blank">���������</a> ������������� �����</label>
</div>
<input type="submit" class="subm_button" value="�����������" name="singup"/>

</form>
</div>

</div>
</div>
<div class="text_pages_bottom"></div>
</div>







