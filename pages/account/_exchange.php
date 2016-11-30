<?PHP
$_OPTIMIZATION["title"] = "Обменник";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

$summa = 100; // Минимальная сумма
?>  
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>

<?PHP

if(isset($_POST["sum"])){

$sum = intval($_POST["sum"]);

	if($sum >= $summa){
	
		if($user_data["money_p"] >= $sum){
		
		$add_sum = ($sonfig_site["percent_swap"] > 0) ? ( ($sonfig_site["percent_swap"] / 100) * $sum) + $sum : $sum;
		
		$ta = time();
		$td = $ta + 60*60*24*15;
		
		$db->Query("UPDATE db_users_b SET money_b = money_b + $add_sum, money_p = money_p - $sum WHERE id = '$usid'");
		$db->Query("INSERT INTO db_swap_ser (user_id, user, amount_b, amount_p, date_add, date_del) VALUES ('$usid','$usname','$add_sum','$sum','$ta','$td')");
		
		echo "<div class='ok'>Обмен выполнен успешно!</div>";
		
		}else echo "<div class='err'>На Вашем счете не достаточно средств!</div>";
	
	}else echo "<div class='err'>Минимальная сумма для обмена состовляет {$summa}!</div>";

}

?>
<div class="title aligncenter">Обменник</div>
	<div class="clear"></div>
	<div class="text"> В обменном пункте Вы можете обменять Золото для вывода на Золото для покупок. Обмен производится моментально и только в одну сторону. </div>
	<div class="s_divide"></div>
<center>
	<div class="already_got">Вы можете поменять <?=floor($user_data['money_p']);?></div>
</center>
<div class="s_divide"></div>
<div class="adding_funds">
	<form action="" method="post">
	 <div class="add_wrap">
		<input type="number" min="<?=$summa;?>" max="<?=floor($user_data['money_p']);?>" name="sum" id="sum" class="input_text w50p" value="<?=floor($user_data['money_p']);?>" oninput="up(this)" required onkeyup="GetSumPer();"/>
	 </div>
		<input type="hidden" name="per" id="percent" value="<?=$sonfig_site["percent_swap"]; ?>" disabled="disabled"/>
		<input type="submit" name="swap"  class="subm_button topup_button add_wrap_r" value="Обменять" />
	</form>
</div>
<div style="margin-left:230px;" class="bonus_w">
<span>Вы получите золото для покупок</span>
	<div id="res_sum" class="left_b">0.00</div>
</div>




 

<script language="javascript">GetSumPer();</script>


</div>
<div class="text_pages_bottom"></div>
</div>
<script language="javascript">
function up(e) {
  if (e.value.indexOf(".") != '-1') {
    e.value=e.value.substring(0, e.value.indexOf(".") + 0);
  }
  document.getElementById('sum').onkeypress = function (e) {
  return !(/[А-Яа-яA-Za-z ]/.test(String.fromCharCode(e.charCode)));
  }
}
</script>	