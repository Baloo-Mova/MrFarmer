<?PHP
$_OPTIMIZATION["title"] = "Профиль";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>

	<div style="font-size: 19px;" class="block_name">Информация об аккаунте:</div>
<div style="padding: 5px 15px; width: 480px;">
<table width="100%" class="table_info">
<tbody>
<tr class="tr_line">
	<td width="200px"><span>Пополнено:</span></td>
	<td><b><?=floor($prof_data["insert_sum"]); ?></b> руб.</td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>Выведено:</span></td>
	<td><b><?=floor($prof_data["payment_sum"]); ?></b> руб.</td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>Золото (для покупок):</span></td>
	<td><b><?=floor($prof_data["money_b"]); ?></b> [<a href="/account/balance.html"><font color="blue">Пополнить</font></a>]</td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>Золото (на вывод):</span></td>
	<td><b><?=floor($prof_data["money_p"]); ?></b> [<a href="/account/withdraw.html"><font color="blue">Вывести</font></a>]</td>
</tr>

<tr class="tr_line">
	<td width="200px"><span>Заработали на рефералах:</span></td>
	<td><b><?=floor($prof_data["from_referals"]); ?></b> золота</td>
</tr>

</tbody></table>
</div>

	<div style="font-size: 19px;" class="block_name">Регистрационные данные:</div>
<div style="padding: 5px 15px; width: 480px;">
<table width="100%" class="table_info">
<tbody><tr class="tr_line">
	<td width="200px"><span>Псевдоним:</span></td>
	<td><b><?=$prof_data["user"]; ?></b></td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>ID Аккаунта:</span></td>
	<td><b><?=$prof_data["id"]; ?></b></td>

</tr><tr class="tr_line">
	<td width="200px"><span>E-mail:</span></td>
	<td><b><?=$prof_data["email"]; ?></b></td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>Дата регистрации:</span></td>
	<td><b><?=date("d.m.Y в H:i:s",$prof_data["date_reg"]); ?></b></td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>Вас пригласил:</span></td>
	<td><b><?=$prof_data["referer"]; ?></b></td>
</tr>
</tbody></table>
</div>

<div style="font-size: 16px;" class="block_img1">
Для того чтобы еще больше зарабатывать в проекте, приглашайте как можно больше активных рефералов, друзей, знакомых. 
<br>с помощью [<a href="/account/referals.html"><font color="blue">Партнерской программы</font></a>] и вам будет начисляться <b>10%</b><br>
 от суммы пополнений вашими рефералами, также от их зароботка в серфинге и на заданиях.
</div>

 

</div>
<div class="text_pages_bottom"></div>
</div>	