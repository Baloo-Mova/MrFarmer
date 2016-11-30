<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">  
<div class="" style="padding-top:0px;">
	<center><b>Гонки машин</b></center>

Суть игры очень проста <BR />
Необходимо угадать какая машина выиграет гонку!<BR />
В случае выигрыша ваша ставка увеличивается в 2 раза и зачисляется на баланс для покупок!
<BR /><BR />
<center>
<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Гонки машин";
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
if (isset($_POST['stavka'])) {
$naper = intval($_POST['naper']);
$stavka = intval($_POST['stavka']);
$nap = rand(1,3);
$time = time();
		if($stavka <= $user_data['money_b']) {
			if($stavka >= 10) {
				if($naper == 1 or $naper ==  2 or $naper == 3) {
					if($naper == $nap) {
					$sum = $stavka * 2;
					$win = 1;
						echo "<center><font color='green'>Выиграли :) </font>";
						
						$db->Query("UPDATE db_users_b SET money_b = money_b + '$sum' where id = '$usid'");
						$db->Query("INSERT INTO db_tachka  (user_id, login, date, summa, win) VALUES ('$usid', '$uname', '$time', '$sum', '$win')");
						
					} else {
						echo "<center><font color='red'>Проиграли! :)</font>";
						$win = 0;
						$db->Query("UPDATE db_users_b SET money_b = money_b - '$stavka' where id = '$usid'");
						$db->Query("INSERT INTO db_tachka  (user_id, login, date, summa, win) VALUES ('$usid', '$uname', '$time', '$stavka', '$win')");
					}
				}else echo "<center><font color='red'>Выберете тачку!</font>";
			}else echo "<center><font color='red'>Минимальная ставка 10 серебра!</font>";
		}else echo "<center><font color='red'>Недостаточно серебра на балансе!</font>";
}
?>










<form method="post" action="">

<input class="poilop" type="text" name="stavka" value="100"><br>



<?php
if ($win == 1 and $naper == 1) {
?>

<img src="/img/tachka3p.png">
<? } else { ?>
<img src="/img/tachka.png">
<? } ?>
<div class="silver-tachka4ik">
<input type="radio" name="naper" value="1">
</div>

<?php
if ($win == 1 and $naper == 2) {
?>

<img src="/img/tachka3p.png">
<? } else { ?>
<img src="/img/tachka.png">
<? } ?>
<center><p> </p></center>
<div class="silver-tachka4ik">
<input type="radio" name="naper" value="2">
</div>

<?php
if ($win == 1 and $naper == 3) {
?>

<img src="/img/tachka3p.png">
<? } else { ?>
<img src="/img/tachka.png">
<? } ?>
<center><p> </p></center>
<div class="silver-tachka4ik">
<input type="radio" name="naper" value="3">
</div>









<br>
<input style="height:25px;" class="btn_2d" type="submit" value="Играть">

</form>

</center>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><h1>Ваши последние игры</h1></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">Сумма</td>
	<td align="center" class="m-tb">Дата</td>
	<td align="center" class="m-tb">Статус</td>
	
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM db_tachka WHERE user_id = '$usid' ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		if ($ref["win"] == 1) { 
		$winn = '<font color="green">Победа</font>'; 
		} else { 
		$winn = '<font color="red">Проигрыш</font>'; 
		}
		$date = date('d-m-Y', $ref["date"]);
		?>
		<tr class="htt">
    		<td align="center"><?=$ref["summa"]; ?> </td>
			<td align="center"><?=$date; ?></td>
			<td align="center"><?=$winn; ?></td>
    		
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">Нет записей</td></tr>'
  
  ?>

  
  
</table>
	

</div>
</div>
<div class="text_pages_bottom"></div>
</div>