<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Продать продукцию";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

?>

<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="text" style="padding-top:0px;">
	
<?PHP
# Продажа
if(isset($_POST["sell"])){

$all_items = $user_data["a_b"] + $user_data["b_b"] + $user_data["c_b"] + $user_data["d_b"] + $user_data["e_b"];

	if($all_items > 0){
	
		$money_add = $func->SellItems($all_items, $sonfig_site["items_per_coin"]);
		
		$tomat_b = $user_data["a_b"];
		$straw_b = $user_data["b_b"];
		$pump_b = $user_data["c_b"];
		$pean_b = $user_data["d_b"];
		$peas_b = $user_data["e_b"];
		
		$money_b = ( (100 - $sonfig_site["percent_sell"]) / 100) * $money_add;
		$money_p = ( ($sonfig_site["percent_sell"]) / 100) * $money_add;
		
		# Обновляем юзверя
		$db->Query("UPDATE db_users_b SET money_b = money_b + '$money_b', money_p = money_p + '$money_p', a_b = 0, b_b = 0, c_b = 0, d_b = 0, e_b = 0 
		WHERE id = '$usid'");
		
		$da = time();
		$dd = $da + 60*60*24*15;
		
		# Вставляем запись в статистику
		$db->Query("INSERT INTO db_sell_items (user, user_id, a_s, b_s, c_s, d_s, e_s, amount, all_sell, date_add, date_del) VALUES 
		('$usname','$usid','$tomat_b','$straw_b','$pump_b','$pean_b','$peas_b','$money_add','$all_items','$da','$dd')");
		
		echo "<div class='ok'>Вы продали {$all_items} продукции, на сумму {$money_add} золота</div>";
		
		$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
		$user_data = $db->FetchArray();
		
	}else echo '<div class="err">Не достаточно продукции для продажи!</div>';

}
?>	
Здесь вы можете продать всю вашу продукцию за золото, которое можно обменять на реальные деньги. 
Вырученное с продажи золото распределяется между двумя счетами (счет для покупок и счет для вывода) 
в пропорциях: <?=100-$sonfig_site["percent_sell"]; ?>% на счет для покупок и <?=$sonfig_site["percent_sell"]; ?>% на вывод.
<br />
<center>Курс продажи : <?=$sonfig_site["items_per_coin"]; ?> единиц продукции = 1 золото.</center>
<br />      
<br />      
<br />      
<form action="" method="post">
<table width="480" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" align="center" valign="middle"><strong>Продукция</strong></td>
    <td height="30" align="center" valign="middle"><strong>Количество</strong></td>
    <td height="30" align="center" valign="middle"><strong>На сумму (золота)</strong></td>
  </tr>
  <tr>
    <td width="30" height="30" align="center" valign="middle"><div class="sm-line-nt"><img width="30" class="p_m_left" src="/images/eggs.png"></div></td>
    <td align="center" valign="middle"><?=$user_data["a_b"]; ?> </td>
    <td align="center" valign="middle"><?=$func->SellItems($user_data["a_b"], $sonfig_site["items_per_coin"]); ?></td>
  </tr>
  <tr>
    <td width="30" height="30" align="center" valign="middle"><div class="sm-line-nt"><img width="30" class="p_m_left" src="/images/meat.png"></div></td>
    <td align="center" valign="middle"><?=$user_data["b_b"]; ?>  </td>
    <td align="center" valign="middle"><?=$func->SellItems($user_data["b_b"], $sonfig_site["items_per_coin"]); ?></td>
  </tr>
  <tr>
    <td width="30" height="30" align="center" valign="middle"><div class="sm-line-nt"><img width="30" class="p_m_left" src="/images/wool.png"></div></td>
    <td align="center" valign="middle"><?=$user_data["c_b"]; ?> </td>
    <td align="center" valign="middle"><?=$func->SellItems($user_data["c_b"], $sonfig_site["items_per_coin"]); ?></td>
  </tr>
  <tr>
    <td width="30" height="30" align="center" valign="middle"><div class="sm-line-nt"><img width="30" class="p_m_left" src="/images/milk.png"></div></td>
    <td align="center" valign="middle"><?=$user_data["d_b"]; ?>  </td>
    <td align="center" valign="middle"><?=$func->SellItems($user_data["d_b"], $sonfig_site["items_per_coin"]); ?></td>
  </tr>
  <tr>
    <td width="30" height="30" align="center" valign="middle"><div class="sm-line-nt"><img width="30" class="p_m_left" src="/images/milk.png"></div></td>
    <td align="center" valign="middle"><?=$user_data["e_b"]; ?>  </td>
    <td align="center" valign="middle"><?=$func->SellItems($user_data["e_b"], $sonfig_site["items_per_coin"]); ?></td>
  </tr>
  
  <tr>
    <td align="center" valign="middle" colspan="3">
	<BR />
	<input type="submit" name="sell" value="Продать все" class="button_0" style="height: 30px;"></td>
  </tr>
  
</table>
</form>



</div>
</div>
<div class="text_pages_bottom"></div>
</div>
