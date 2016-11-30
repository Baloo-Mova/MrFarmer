<div class="s-bk-lf">
	<div class="acc-title">Заказ выплаты</div>
</div>
<div class="silver-bk">
<BR />
<?PHP
$_OPTIMIZATION["title"] = " Заказ выплаты";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();


$min_ser = $sonfig_site["min_pay"] * $sonfig_site["ser_per_wmr"];

$status_array = array( 0 => "В очереди", 1 => "Выплачен", 2 => "Отменен");


# Список платежек
if(!isset($_GET["pay_id"])){

	if(isset($_POST["sys_pay"])){ Header("Location: /account/payment/".$_POST["sys_pay"]); return; }

	$db->Query("SELECT * FROM db_pay_systems ORDER BY id DESC");

	if($db->NumRows() == 0){ echo "<center>Нет платежных систем :(</center><BR /><div class='clr'></div></div>	"; return; }

	?>

	<form action="" method="POST">
	<center>Укажите более подходящую для Вас платежную систему из списка имеющихся. <BR /><BR />
		<select name="sys_pay">
		<?PHP

			while($data = $db->FetchArray()){

				?><option value="<?=$data["id"]; ?>"><?=$data["title"]; ?></option><?PHP

			}

		?>
		</select>
		<BR /><BR />
		<input type="submit" class="btn btn-success" value="Выбрать" />
	</center>
	</form>
	<div class="clr"></div>
</div>
	<?PHP

return;
}else{

	$pay_id = intval($_GET["pay_id"]);

	$db->Query("SELECT * FROM db_pay_systems WHERE id = '$pay_id'");

	if($db->NumRows() == 0){ echo "<center>Такой платежной системы нет в нашем проекте :(</center><BR /><div class='clr'></div></div>"; return; }

	$pdata = $db->FetchArray();
	$min_ser = $pdata["min_pay"] * $sonfig_site["ser_per_wmr"];
	$ps = $pdata["title"];


	# Создание заявки на выплату
	if(isset($_POST["pp"])){

		$purse = strval(trim($func->TextClean($_POST["pp"])));
		$sum = intval($_POST["sum"]);

		if( strlen($purse) > 5){

			if( substr($purse, 0, 1) == $pdata["first_char"] ){

				if($min_ser <= $sum){

					if($sum <= $user_data["money_p"]){

							# Проверяем на существующие заявки
							$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$usid' AND status = 0");
							if($db->FetchRow() == 0){

							# Снимаем с пользователя
							$db->Query("UPDATE db_users_b SET money_p = money_p - '$sum' WHERE id = '$usid'");

							# Вставляем запись в выплаты
							$da = time();
							$dd = $da + 60*60*24*15;
							$sum_r = round($sum / $sonfig_site["ser_per_wmr"], 2);
							$db->Query("INSERT INTO db_payment (user, user_id, purse, sum, serebro, pay_sys, date_add, date_del)
							VALUES ('$usname','$usid','$purse','$sum_r','$sum','$ps','$da','$dd')");

							echo "<center><div class='alert alert-success'><b>Ваша заявка отправлена в очередь на выполнение</b></div></center><BR />";

							}else echo "<center><font color = 'red'><b>У вас имеются необработанные заявки. Дождитесь их выполнения.</b></font></center><BR />";


					}else echo "<center><div class='alert alert-error'><b>Вы указали больше, чем имеется на вашем счету</b></div></center><BR />";

				}else echo "<center><div class='alert alert-error'><b>Минимальная сумма для вывода {$min_ser} серебра</b></div></center><BR />";

			}else echo "<center><div class='alert alert-error'><b>Кошелек должен начинаться с ".$pdata["first_char"]."</b></div></center><BR />";

		}else echo "<center><div class='alert alert-error'><b>Кошелек заполнен неверно</b></div></center><BR />";

	}



?>


<form action="" method="post">
<table width="99%" border="0" align="center">
  <tr>
    <td><font color="#000;">Кошелек</font> [Начинается с <?=$pdata["first_char"]; ?>]<font color="#000;">:</font> </td>
	<td><input type="text" name="pp" size="15"/></td>
  </tr>
  <tr>
    <td><font color="#000;">Отдаете серебро для вывода</font> [Мин. <?=$min_ser; ?>]<font color="#000;">:</font> </td>
	<td><input type="text" name="sum" id="sum" value="<?=$min_ser; ?>" size="15" onkeyup="PaymentSum();" /></td>
  </tr>
  <tr>
    <td><font color="#000;">Получаете <?=$config->VAL; ?></font> [Без учета комиссии]<font color="#000;">:</font> </td>
	<td>
	<input type="text" name="res" id="res_sum" value="0" size="15" disabled="disabled"/>
	<input type="hidden" name="per" id="ser_per" value="<?=$sonfig_site["ser_per_wmr"]; ?>" disabled="disabled"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="swap" value="Заказать выплату" class="btn btn-success" style="height: 30px; margin-top:10px;" /></td>
  </tr>
</table>
</form>
<script language="javascript">PaymentSum();</script>

<?PHP } ?>

<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><h4>Последние 10 выплат</h4></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">Серебро</td>
    <td align="center" class="m-tb">Получаете</td>
	<td align="center" class="m-tb">Кошелек</td>
	<td align="center" class="m-tb">Дата</td>
	<td align="center" class="m-tb">Статус</td>
  </tr>
  <?PHP

  $db->Query("SELECT * FROM db_payment WHERE user_id = '$usid' ORDER BY id DESC LIMIT 10");

	if($db->NumRows() > 0){

  		while($ref = $db->FetchArray()){

		?>
		<tr class="htt">
    		<td align="center"><?=$ref["serebro"]; ?></td>
    		<td align="center"><?=sprintf("%.2f",$ref["sum"]); ?> RUB</td>
    		<td align="center"><?=$ref["purse"]; ?></td>
			<td align="center"><?=date("d.m.Y",$ref["date_add"]); ?></td>
    		<td align="center"><?=$status_array[$ref["status"]]; ?></td>
  		</tr>
		<?PHP

		}

	}else echo '<tr><td align="center" colspan="5">Нет записей</td></tr>'
  ?>


</table><div class="clr"></div>
</div><p>

<center><script type="text/javascript" language="JavaScript">
function changeImg(source,links)
{ document.getElementById('pict').src = source;
  document.getElementById('link').href = links;
};
</script>
 
<a href="" id="link"><img src="http://farm-sell.ru/img/copyright1.png" id="pict" border=0
onMouseOver="changeImg('http://farm-sell.ru/img/copyright.png', 'http://farm-sell.ru/')"
onMouseOut="changeImg('http://farm-sell.ru/img/copyright1.png', '')" ></a>
 </a></center>
