<?
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$cena = 10; //Стоимость отправки сообщения пользователю
$cena_ref = 25;// Стоимость отправки сообщения рефералам!
?>

<div class="s-bk-lf"><div class="acc-title">Внутреняя почта</div></div>

<?

	
	$db->Query("SELECT * FROM wmrush_pm WHERE user_id_in = '$usid' AND status = 0 AND inbox = 1");
	$sk = $db->NumRows();
	if ($sk > 0) {$pmm = '<font color="red">('.$sk.')</font>';} else {$pmm = '<font color="red">(0)</font>';}
	
?>

<div class="silver-bk"><div class="clr"></div>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
   <tr>
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/'>Написать Письмо</a></td>
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/inbox/'>Входящие<?=$pmm; ?></a></td>	
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/outbox/'>Исходящие</a></td>
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/referals/'>Рассылка всем рефералам</a></td>
  </tr>
</table>

<?



















/////////////////////////////////////////////////############### ВХОДЯЩИЕ СООБЩЕНИЯ  ###################///////////////////////////////////////////////
if (isset($_GET['inbox'])) {


if(isset($_POST['tema1'])) {
$tema1 = htmlspecialchars($_POST['tema1']);
$text1 = htmlspecialchars($_POST['message1']);
$user = htmlspecialchars($_POST['to_user1']);
$db->Query("SELECT * FROM db_users_a WHERE user = '$user'");
$use = $db->FetchArray();
$us_in = $use['id'];
$date = time();
if(!empty($tema1)) {
	if(!empty($text1)) {

						$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, inbox) VALUES ('$us_in', '$user', '$usid', '$usname', '$tema1', '$text1', '$status', '$date', 1)");
						
						$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, outbox) VALUES ('$us_in', '$user', '$usid', '$usname', '$tema1', '$text1', '$status', '$date', 1)");
						$db->Query("UPDATE db_users_b SET money_b = money_b - '$cena' WHERE id = '$usid'");
					//	echo $tema1;
						echo 'Ваше сообщение отправленно';
	}else echo '<center><font color="red">Введите текст сообщения</font></center>';
}else echo '<center><font color="red">Введите тему сообщения</font></center>';

}


if (isset($_POST['tm'])) {				
?>

<form method="post" action="">
<label>Пользователь(логин)</label><br>
<input value="<?=$_POST['log']; ?>" type="text" size="20" maxlength="50" disabled /><br>
<input name="to_user1" value="<?=$_POST['log']; ?>" type="hidden" size="20" maxlength="50" /><br>
<label>Тема сообщения (до 150 символов)</label><br>
<input value="RE: <?=$_POST['tm']; ?>" type="text" size="20" maxlength="150" disabled /><br>
<input name="tema1" value="RE: <?=$_POST['tm']; ?>" type="hidden" size="20" maxlength="150" />
<label>Текст сообщения</label><br>
<textarea name="message1" rows="5" cols="40"></textarea>
<br />
<input type="submit" name="sendd" value="Отправить сообщение" />
</form>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>

<?
}

if(isset($_POST['id_dell_in'])) {
$id_dell_in = intval($_POST['id_dell_in']);
$db->Query("DELETE FROM wmrush_pm WHERE id = '$id_dell_in' AND user_id_in = '$usid'");
echo '<center>Сообщение удалено</center><br>';
}


	if (isset($_POST['id_in'])) {
	$id_in = intval($_POST['id_in']);
	$db->Query("UPDATE wmrush_pm SET status = 1 WHERE id = '$id_in'");
	$db->Query("SELECT * FROM wmrush_pm WHERE id = '$id_in' AND user_id_in = '$usid'");
	$inn = $db->FetchArray();
	?>
	<br>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
<b>Отправитель</b> - <?=$inn['login_out']; ?> | <?=date('d-m-Y - H:i', $in['date']); ?><br>
<b>Тема</b> - <?=$inn['theme']; ?><br>
<b>Текст письма</b><br>
<?=$inn['text']; ?><br><br>


<hr>





</td></tr></tbody></table>
<form method="post" action="">
<input type="hidden" name="tm" value="<?=$inn['theme']; ?>">
<input type="hidden" name="log" value="<?=$inn['login_out']; ?>">
<input type="submit" value="Ответить">

</form>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</div><br>
	
	<?
	}


	$db->Query("SELECT * FROM wmrush_pm WHERE user_id_in = '$usid' AND inbox = 1 ORDER BY id DESC LIMIT 30");
	if($db->NumRows() == 0) {
	echo '<center>Нет входящих сообщений</center>';
	?>
	  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
	<?
	
	}
	while($in = $db->FetchArray()) {
	?>
	<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
</td></tr></tbody></table>

<table width='97%'>
<tr bgcolor="#336633">
<td align='center'>ID</td>
<td align='center'>Отправитель</td>
<td align='center'>Тема</td>
<td align='center'>Дата</td>
<td align='center'>Функция</td>
</tr>

<tr
bgcolor="grey">
<td align='center'>#<?=$in['id']; ?><br>
<?
if ($in['status'] == 0) echo '<font color="red">NEW</font>';
?>

</td>
<td align='center'><?=$in['login_out']; ?></td>
<td align='center'><?=$in['theme']; ?></td>
<td align='center'><?=date('d-m-Y - H:i', $in['date']); ?></td>
<td align='center'>
<form action="" method="post"><input type="hidden" name="id_in" value="<?=$in['id']; ?>"><input type="submit" name="outbox" value="Просмотр"></form><br>

<form action="" method="post"><input type="hidden" name="id_dell_in" value="<?=$in['id']; ?>"><input type="hidden" name="del" value="yes"><input type="submit" name="outbox" value="Удалить"></form>
</td>
</tr>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</table>
	<?
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/////////////////////////////////////////////////############### ИСХОДЯЩИЕ СООБЩЕНИЯ  ###################///////////////////////////////////////////////
}elseif (isset($_GET['outbox'])) {







if(isset($_POST['id_dell_in'])) {
$id_dell_in = intval($_POST['id_dell_in']);
$db->Query("DELETE FROM wmrush_pm WHERE id = '$id_dell_in' AND user_id_out = '$usid'");
echo '<center>Сообщение удалено</center><br>';
}


	if (isset($_POST['id_in'])) {
	$id_in = intval($_POST['id_in']);
	$db->Query("SELECT * FROM wmrush_pm WHERE id = '$id_in' AND user_id_out = '$usid'");
	$inn = $db->FetchArray();
	?>
	<br>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
<b>Получатель</b> - <?=$inn['login_in']; ?> | <?=date('d-m-Y - H:i', $in['date']); ?><br>
<b>Тема</b> - <?=$inn['theme']; ?><br>
<b>Текст письма</b><br>
<?=$inn['text']; ?><br><br>

<hr>



</td></tr>
</tbody></table>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>

</div><br>
	
	<?
	}


	$db->Query("SELECT * FROM wmrush_pm WHERE user_id_out = '$usid' AND outbox = 1 ORDER BY id DESC LIMIT 30");
	if($db->NumRows() == 0) {
	echo '<center>Нет входящих сообщений</center>';
	?>
	  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
	<?
	}
	while($in = $db->FetchArray()) {
	?>
	<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
</td></tr></tbody></table>

<table width='97%'>
<tr bgcolor="#336633">
<td align='center'>ID</td>
<td align='center'>Получатель</td>
<td align='center'>Тема</td>
<td align='center'>Дата</td>
<td align='center'>Функция</td>
</tr>

<tr
bgcolor="grey">
<td align='center'>#<?=$in['id']; ?></td>
<td align='center'><?=$in['login_in']; ?></td>
<td align='center'><?=$in['theme']; ?></td>
<td align='center'><?=date('d-m-Y - H:i', $in['date']); ?></td>
<td align='center'>
<form action="" method="post"><input type="hidden" name="id_in" value="<?=$in['id']; ?>"><input type="submit" name="outbox" value="Просмотр"></form><br>
<form action="" method="post"><input type="hidden" name="id_dell_in" value="<?=$in['id']; ?>"><input type="hidden" name="del" value="yes"><input type="submit" name="outbox" value="Удалить"></form>
</td>
</tr>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</table>
<?
}




















/////////////////////////////////////////////////############### СООБЩЕНИЯ РЕФЕРАЛАМ ###################///////////////////////////////////////////////
}elseif (isset($_GET['referals'])) {
$qq = time() - 86400; //Активные в течении суток
$ww = time() - 259200; // Активные в течении 3-х дней
$ee = time() - 604800; // Активные в течении недели
$rr = time() - 2629743; // Активные в течении месяца
$hh = $db->Query("SELECT 
(SELECT COUNT(id) FROM db_users_a WHERE referer_id = '$usid') all_users,
(SELECT COUNT(id) FROM db_users_a WHERE referer_id = '$usid' AND date_login >= '$qq') all_insert, 
(SELECT COUNT(id) FROM db_users_a WHERE referer_id = '$usid' AND date_login >= '$ww') all_payment, 
(SELECT COUNT(id) FROM db_users_a WHERE referer_id = '$usid' AND date_login >= '$ee') new_users,
(SELECT COUNT(id) FROM db_users_a WHERE referer_id = '$usid' AND date_login >= '$rr') new_userss");
$ref_data = $db->FetchArray($hh);


if(isset($_POST['type'])) {
$type = intval($_POST['type']);
$text = htmlspecialchars($_POST['message']);
$tema = htmlspecialchars($_POST['tema']);
$date = time();
$status = 0;
	if(!empty($tema)) {
		if(!empty($text)) {
			if(!empty($type)) {
				if($ref_data['all_users'] !=0) {
					if($type == 1) {
					//$db->Query("SELECT * FROM db_users_a WHERE referer_id = '$usid'");
						//while($reff = $db->FetchArray()) {
						//for($i = 1; $i < $ref_data['all_users']; $i++) {
						$con = mysql_connect($config->HostDB, $config->UserDB, $config->PassDB);
						$cl = mysql_select_db($config->BaseDB, $con);
							$qqqqq = mysql_query("SELECT * FROM db_users_a WHERE referer_id = '$usid'");  //All
							while($reff = mysql_fetch_array($qqqqq)){
							$rre = $reff['id'];
							$r_log = $reff['user'];
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, inbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, outbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							$db->Query("UPDATE db_users_b SET money_b = money_b - '$cena_ref' WHERE id = '$usid'");
							//echo $cena_ref;
							}
							
							echo '<center><font color="green">Сообщения отправлены </font></center>';
							
						//}
					}elseif($type == 2) {
					$con = mysql_connect($config->HostDB, $config->UserDB, $config->PassDB);
					$cl = mysql_select_db($config->BaseDB, $con);
							$qqqqq = mysql_query("SELECT * FROM db_users_a WHERE referer_id = '$usid' AND date_login >= '$qq' "); //Sutki
							while($reff = mysql_fetch_array($qqqqq)){
							$rre = $reff['id'];
							$r_log = $reff['user'];
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, inbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, outbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							$db->Query("UPDATE db_users_b SET money_b = money_b - '$cena_ref' WHERE id = '$usid'");
						//	echo $cena_ref;
							}
							
							echo '<center><font color="green">Сообщения отправлены </font></center>';
					
					}elseif($type == 3) {
					$con = mysql_connect($config->HostDB, $config->UserDB, $config->PassDB);
						$cl = mysql_select_db($config->BaseDB, $con);
							$qqqqq = mysql_query("SELECT * FROM db_users_a WHERE referer_id = '$usid' AND date_login >= '$ww'"); //3 Dnya
							while($reff = mysql_fetch_array($qqqqq)){
							$rre = $reff['id'];
							$r_log = $reff['user'];
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, inbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, outbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							$db->Query("UPDATE db_users_b SET money_b = money_b - '$cena_ref' WHERE id = '$usid'");
						//	echo $cena_ref;
							}
							
							echo '<center><font color="green">Сообщения отправлены </font></center>';
					
					}elseif($type == 4){
					$con = mysql_connect($config->HostDB, $config->UserDB, $config->PassDB);
						$cl = mysql_select_db($config->BaseDB, $con);
							$qqqqq = mysql_query("SELECT * FROM db_users_a WHERE referer_id = '$usid'  AND date_login >= '$ee'"); //7 dney
							while($reff = mysql_fetch_array($qqqqq)){
							$rre = $reff['id'];
							$r_log = $reff['user'];
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, inbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, outbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							$db->Query("UPDATE db_users_b SET money_b = money_b - '$cena_ref' WHERE id = '$usid'");
						//	echo $cena_ref;
							}
							
							echo '<center><font color="green">Сообщения отправлены </font></center>';
					}elseif($type == 5) {
					$con = mysql_connect($config->HostDB, $config->UserDB, $config->PassDB);
						$cl = mysql_select_db($config->BaseDB, $con);
							$qqqqq = mysql_query("SELECT * FROM db_users_a WHERE referer_id = '$usid' AND date_login >= '$rr'"); //1 mesyac
							while($reff = mysql_fetch_array($qqqqq)){
							$rre = $reff['id'];
							$r_log = $reff['user'];
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, inbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							
							$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, outbox) VALUES ('$rre', '$r_log', '$usid', '$usname', '$tema', '$text', '$status', '$date', 1)");
							$db->Query("UPDATE db_users_b SET money_b = money_b - '$cena_ref' WHERE id = '$usid'");
						//	echo $cena_ref;
							}
							
							echo '<center><font color="green">Сообщения отправлены </font></center>';
					
					}
				}else echo '<center><font color="red">У Вас нет рефералов</font></center>';
			}else  echo '<center><font color="red">Выберите тип рассылки</font></center>';
		}else  echo '<center><font color="red">Введите текст сообщения</font></center>';
	}else  echo '<center><font color="red">Введите тему сообщения</font></center>';

}
?>
<br>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
Рассылка сообщений своим рефералам это:<br>
- Максимальная выгода с людей , что привлекли;<br>
- Вы сможете рассылать всем своим рефералам за раз;<br>
- Можно выбрать только самых активных рефералов;<br>
- Сообщения останутся в исходящих.<br>
<br>
Стоимость отправки 1 сообщение 1 рефералу - 25 C.
<br><br>
<?

?>
<form method="post" action="">
<label>Вид рассылки</label><br>
<select name="type" size="1">
<option value="1">Всем рефералам [<?=$ref_data['all_users']; ?>]</option>
<option value="2">Активным в течении 24 часов [<?=$ref_data['all_insert']; ?>]</option>
<option value="3">Активным в течении 3 суток [<?=$ref_data['all_payment']; ?>]</option>
<option value="4">Активным в течении 7 суток [<?=$ref_data['new_users']; ?>]</option>
<option value="5">Активным в течении месяца [<?=$ref_data['new_userss']; ?>]</option>
</select>
<br>
<label>Тема сообщения (до 150 символов)</label><br>
<input name="tema" value="" type="text" size="20" maxlength="150" /><br>
<label>Текст сообщения</label><br>
<textarea name="message" rows="5" cols="40"></textarea>
<br />
<input type="submit" name="send" value="Разослать сообщение" />
</form>
</td></tr>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>

</tbody></table>

<? 
























/////////////////////////////////////////////////############### НОВОЕ СООБЩЕНИЯ  ###################///////////////////////////////////////////////
} else { 

if (isset($_POST['to_user'])) {
$to_user = htmlspecialchars($_POST['to_user']);
$theme = htmlspecialchars($_POST['tema']);
$text = htmlspecialchars($_POST['message']);

$status = 0;
$date = time();
$db->Query("SELECT * FROM db_users_a WHERE user = '$to_user'");
$kol = $db->NumRows();
$us = $db->FetchArray();
$us_in = $us['id'];
$login_in = $us['user'];
	if($kol > 0) {
		if($us['user'] != $usname) {
			if(!empty($theme)) {
				if(!empty($text)) {
					if($cena <= $user_data['money_b']) {
						$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, inbox) VALUES ('$us_in', '$login_in', '$usid', '$usname', '$theme', '$text', '$status', '$date', 1)");
						
						$db->Query("INSERT INTO wmrush_pm (user_id_in, login_in, user_id_out, login_out, theme, text, status, date, outbox) VALUES ('$us_in', '$login_in', '$usid', '$usname', '$theme', '$text', '$status', '$date', 1)");
						$db->Query("UPDATE db_users_b SET money_b = money_b - '$cena' WHERE id = '$usid'");
						echo '<center><font color="green">Ваше сообщение отправлено пользователю '.$login_in.'</font></center>';
					}else  echo '<center><font color="red">У вас не достаточно средств для отправки сообщения</font></center>';
				}else echo '<center><font color="red">Введите текст сообщения</font></center>';
			}else  echo '<center><font color="red">Введите тему сообщения</font></center>';
		}else  echo '<center><font color="red">Нельзя отправлять сообщения самому себе</font></center>';
	}else echo '<center><font color="red">Пользователя не существует</font></center>';

}


?>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
<br>
Запрещено:<br>
- Отправлять сообщения содержащие ненормативную лексику;<br>
- Оскорблять других пользователей проекта;<br>
- Отправлять сообщения рекламного характера;<br>
- Массовая отправка сообщений одного содержания.<br>
<br>
Стоимость отправки сообщения - 10 C.
<br><br>
<form method="post" action="">
<label>Пользователь(логин)</label><br>
<input name="to_user" value="" type="text" size="20" maxlength="50" /><br>
<label>Тема сообщения (до 150 символов)</label><br>
<input name="tema" value="" type="text" size="20" maxlength="150" /><br>
<label>Текст сообщения</label><br>
<textarea name="message" rows="5" cols="40"></textarea>
<br />
<input type="submit" name="send" value="Отправить сообщение" />
</form>
</td></tr>

  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</tbody></table>

<? } ?>
</div><br>

</div>	