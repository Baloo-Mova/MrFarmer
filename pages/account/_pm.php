<?
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$cena = 10; //��������� �������� ��������� ������������
$cena_ref = 25;// ��������� �������� ��������� ���������!
?>

<div class="s-bk-lf"><div class="acc-title">��������� �����</div></div>

<?

	
	$db->Query("SELECT * FROM wmrush_pm WHERE user_id_in = '$usid' AND status = 0 AND inbox = 1");
	$sk = $db->NumRows();
	if ($sk > 0) {$pmm = '<font color="red">('.$sk.')</font>';} else {$pmm = '<font color="red">(0)</font>';}
	
?>

<div class="silver-bk"><div class="clr"></div>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
   <tr>
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/'>�������� ������</a></td>
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/inbox/'>��������<?=$pmm; ?></a></td>	
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/outbox/'>���������</a></td>
    <td align="center" class="m-tb"><a style='color:white;' href='/account/pm/referals/'>�������� ���� ���������</a></td>
  </tr>
</table>

<?



















/////////////////////////////////////////////////############### �������� ���������  ###################///////////////////////////////////////////////
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
						echo '���� ��������� �����������';
	}else echo '<center><font color="red">������� ����� ���������</font></center>';
}else echo '<center><font color="red">������� ���� ���������</font></center>';

}


if (isset($_POST['tm'])) {				
?>

<form method="post" action="">
<label>������������(�����)</label><br>
<input value="<?=$_POST['log']; ?>" type="text" size="20" maxlength="50" disabled /><br>
<input name="to_user1" value="<?=$_POST['log']; ?>" type="hidden" size="20" maxlength="50" /><br>
<label>���� ��������� (�� 150 ��������)</label><br>
<input value="RE: <?=$_POST['tm']; ?>" type="text" size="20" maxlength="150" disabled /><br>
<input name="tema1" value="RE: <?=$_POST['tm']; ?>" type="hidden" size="20" maxlength="150" />
<label>����� ���������</label><br>
<textarea name="message1" rows="5" cols="40"></textarea>
<br />
<input type="submit" name="sendd" value="��������� ���������" />
</form>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>

<?
}

if(isset($_POST['id_dell_in'])) {
$id_dell_in = intval($_POST['id_dell_in']);
$db->Query("DELETE FROM wmrush_pm WHERE id = '$id_dell_in' AND user_id_in = '$usid'");
echo '<center>��������� �������</center><br>';
}


	if (isset($_POST['id_in'])) {
	$id_in = intval($_POST['id_in']);
	$db->Query("UPDATE wmrush_pm SET status = 1 WHERE id = '$id_in'");
	$db->Query("SELECT * FROM wmrush_pm WHERE id = '$id_in' AND user_id_in = '$usid'");
	$inn = $db->FetchArray();
	?>
	<br>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
<b>�����������</b> - <?=$inn['login_out']; ?> | <?=date('d-m-Y - H:i', $in['date']); ?><br>
<b>����</b> - <?=$inn['theme']; ?><br>
<b>����� ������</b><br>
<?=$inn['text']; ?><br><br>


<hr>





</td></tr></tbody></table>
<form method="post" action="">
<input type="hidden" name="tm" value="<?=$inn['theme']; ?>">
<input type="hidden" name="log" value="<?=$inn['login_out']; ?>">
<input type="submit" value="��������">

</form>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</div><br>
	
	<?
	}


	$db->Query("SELECT * FROM wmrush_pm WHERE user_id_in = '$usid' AND inbox = 1 ORDER BY id DESC LIMIT 30");
	if($db->NumRows() == 0) {
	echo '<center>��� �������� ���������</center>';
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
<td align='center'>�����������</td>
<td align='center'>����</td>
<td align='center'>����</td>
<td align='center'>�������</td>
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
<form action="" method="post"><input type="hidden" name="id_in" value="<?=$in['id']; ?>"><input type="submit" name="outbox" value="��������"></form><br>

<form action="" method="post"><input type="hidden" name="id_dell_in" value="<?=$in['id']; ?>"><input type="hidden" name="del" value="yes"><input type="submit" name="outbox" value="�������"></form>
</td>
</tr>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</table>
	<?
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/////////////////////////////////////////////////############### ��������� ���������  ###################///////////////////////////////////////////////
}elseif (isset($_GET['outbox'])) {







if(isset($_POST['id_dell_in'])) {
$id_dell_in = intval($_POST['id_dell_in']);
$db->Query("DELETE FROM wmrush_pm WHERE id = '$id_dell_in' AND user_id_out = '$usid'");
echo '<center>��������� �������</center><br>';
}


	if (isset($_POST['id_in'])) {
	$id_in = intval($_POST['id_in']);
	$db->Query("SELECT * FROM wmrush_pm WHERE id = '$id_in' AND user_id_out = '$usid'");
	$inn = $db->FetchArray();
	?>
	<br>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
<b>����������</b> - <?=$inn['login_in']; ?> | <?=date('d-m-Y - H:i', $in['date']); ?><br>
<b>����</b> - <?=$inn['theme']; ?><br>
<b>����� ������</b><br>
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
	echo '<center>��� �������� ���������</center>';
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
<td align='center'>����������</td>
<td align='center'>����</td>
<td align='center'>����</td>
<td align='center'>�������</td>
</tr>

<tr
bgcolor="grey">
<td align='center'>#<?=$in['id']; ?></td>
<td align='center'><?=$in['login_in']; ?></td>
<td align='center'><?=$in['theme']; ?></td>
<td align='center'><?=date('d-m-Y - H:i', $in['date']); ?></td>
<td align='center'>
<form action="" method="post"><input type="hidden" name="id_in" value="<?=$in['id']; ?>"><input type="submit" name="outbox" value="��������"></form><br>
<form action="" method="post"><input type="hidden" name="id_dell_in" value="<?=$in['id']; ?>"><input type="hidden" name="del" value="yes"><input type="submit" name="outbox" value="�������"></form>
</td>
</tr>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</table>
<?
}




















/////////////////////////////////////////////////############### ��������� ��������� ###################///////////////////////////////////////////////
}elseif (isset($_GET['referals'])) {
$qq = time() - 86400; //�������� � ������� �����
$ww = time() - 259200; // �������� � ������� 3-� ����
$ee = time() - 604800; // �������� � ������� ������
$rr = time() - 2629743; // �������� � ������� ������
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
							
							echo '<center><font color="green">��������� ���������� </font></center>';
							
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
							
							echo '<center><font color="green">��������� ���������� </font></center>';
					
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
							
							echo '<center><font color="green">��������� ���������� </font></center>';
					
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
							
							echo '<center><font color="green">��������� ���������� </font></center>';
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
							
							echo '<center><font color="green">��������� ���������� </font></center>';
					
					}
				}else echo '<center><font color="red">� ��� ��� ���������</font></center>';
			}else  echo '<center><font color="red">�������� ��� ��������</font></center>';
		}else  echo '<center><font color="red">������� ����� ���������</font></center>';
	}else  echo '<center><font color="red">������� ���� ���������</font></center>';

}
?>
<br>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
�������� ��������� ����� ��������� ���:<br>
- ������������ ������ � ����� , ��� ���������;<br>
- �� ������� ��������� ���� ����� ��������� �� ���;<br>
- ����� ������� ������ ����� �������� ���������;<br>
- ��������� ��������� � ���������.<br>
<br>
��������� �������� 1 ��������� 1 �������� - 25 C.
<br><br>
<?

?>
<form method="post" action="">
<label>��� ��������</label><br>
<select name="type" size="1">
<option value="1">���� ��������� [<?=$ref_data['all_users']; ?>]</option>
<option value="2">�������� � ������� 24 ����� [<?=$ref_data['all_insert']; ?>]</option>
<option value="3">�������� � ������� 3 ����� [<?=$ref_data['all_payment']; ?>]</option>
<option value="4">�������� � ������� 7 ����� [<?=$ref_data['new_users']; ?>]</option>
<option value="5">�������� � ������� ������ [<?=$ref_data['new_userss']; ?>]</option>
</select>
<br>
<label>���� ��������� (�� 150 ��������)</label><br>
<input name="tema" value="" type="text" size="20" maxlength="150" /><br>
<label>����� ���������</label><br>
<textarea name="message" rows="5" cols="40"></textarea>
<br />
<input type="submit" name="send" value="��������� ���������" />
</form>
</td></tr>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>

</tbody></table>

<? 
























/////////////////////////////////////////////////############### ����� ���������  ###################///////////////////////////////////////////////
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
						echo '<center><font color="green">���� ��������� ���������� ������������ '.$login_in.'</font></center>';
					}else  echo '<center><font color="red">� ��� �� ���������� ������� ��� �������� ���������</font></center>';
				}else echo '<center><font color="red">������� ����� ���������</font></center>';
			}else  echo '<center><font color="red">������� ���� ���������</font></center>';
		}else  echo '<center><font color="red">������ ���������� ��������� ������ ����</font></center>';
	}else echo '<center><font color="red">������������ �� ����������</font></center>';

}


?>
<table style="border-collapse:collapse;width:100%;"><tbody><tr><td><br></td><td>
<br>
���������:<br>
- ���������� ��������� ���������� ������������� �������;<br>
- ���������� ������ ������������� �������;<br>
- ���������� ��������� ���������� ���������;<br>
- �������� �������� ��������� ������ ����������.<br>
<br>
��������� �������� ��������� - 10 C.
<br><br>
<form method="post" action="">
<label>������������(�����)</label><br>
<input name="to_user" value="" type="text" size="20" maxlength="50" /><br>
<label>���� ��������� (�� 150 ��������)</label><br>
<input name="tema" value="" type="text" size="20" maxlength="150" /><br>
<label>����� ���������</label><br>
<textarea name="message" rows="5" cols="40"></textarea>
<br />
<input type="submit" name="send" value="��������� ���������" />
</form>
</td></tr>

  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</tbody></table>

<? } ?>
</div><br>

</div>	