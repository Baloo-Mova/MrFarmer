
<?PHP

	if(isset($_POST["loginform"])){
	if(isset($_SESSION["captcha"]) AND strtolower($_SESSION["captcha"]) == strtolower($_POST["captcha"])){
	unset($_SESSION["captcha"]);
	
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
						Header("Location: /account");
						
		}else echo "<div class='err'>������� ������������</div>";
		}else echo "<div class='err'>������ ������ �������</div>";
		}else echo "<div class='err'>��������� ������������ �� ��������������� � �������</div>";
		}else echo "<div class='err'>Email ������ �������</div>";
		}else echo "<div class='err'>����� ������ �������</div>";
		}else echo "<div class='err'>������� � �������� ������� �������</div>";
	
	}

?>
<form name="loginform" action="" method="post">
�����:<input name="login" type="text" value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>"/> 
Email:<input name="email" type="text" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>"/>
������:<input name="pass" type="password"/></td>

<tr>
    <td align="left" width="250" style="padding-top:20px;">
	<a href="#" onclick="ResetCaptcha(this);"><img src="/captcha.php?rnd=<?=rand(1,10000); ?>"  border="0" style="margin:0;"/></a>
	</td>
    <td align="left" width="250" style="padding-top:20px;">������� ������� � ��������<input name="captcha" type="text" size="25" maxlength="50" /></td>
  </tr>

<input name="loginform" type="submit" value="�����"/>
</form>
     <a href="/signup">�����������"<a/></td>
	 <a href="/recovery" class="rs-ps">������ ������?</a>
 