<div class="s-bk-lf">
	<div class="acc-title">Заказы выплат</div>
</div>
<!--<div class="silver-bk">-->
<div class="text_right">
	<div class="clr"></div>
<BR />
<?PHP


# Выплачено
if(isset($_GET["payment"])){

$ret_id = intval($_GET["payment"]);
$db->Query("SELECT * FROM db_payment WHERE status = '0' AND id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
	$serebro = $ret_data["serebro"];
		
		$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$sum' WHERE id = '$user_id'");
		$db->Query("UPDATE db_payment SET status = '3' WHERE id = '$ret_id'");
		$db->Query("UPDATE db_stats SET all_payments = all_payments + '$sum' WHERE id = '1'");
		
		
		echo "<center><b>Выплачено, статистика обновлена</b></center><BR />";
		
	}else echo "<center><b>Заявка не найдена :(</b></center><BR />";

}

# Возврат
if(isset($_GET["return"])){

$ret_id = intval($_GET["return"]);
$db->Query("SELECT * FROM db_payment WHERE status = '0' AND id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
	$serebro = $ret_data["serebro"];
		
		$db->Query("UPDATE db_users_b SET money_p = money_p + '$serebro' WHERE id = '$user_id'");
		$db->Query("UPDATE db_payment SET status = '2' WHERE id = '$ret_id'");
		
		echo "<center><b>Заявка отменена, средства возвращены</b></center><BR />";
		
	}else{
		echo "<center><b>Заявка не найдена :(</b></center><BR />";
	}

}




$db->Query("SELECT * FROM db_payment ORDER BY date_add DESC LIMIT 50");
$ast = $db->NumRows();
if($ast > 0){

?>
<table cellpadding='3' class="admin_pay_table" cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
	<td align="center" width="75" class="m-tb">Логин</td>
    <td align="center" width="75" class="m-tb">Сумма</td>
	<td align="center" width="100" class="m-tb">Кошелек</td>
	<td align="center" width="50" class="m-tb">Дата</td>
	<td align="center" width="100" class="m-tb">Статус</td>
  </tr>

<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
		<td align="center"><a href="http://mr-farmer.biz/?menu=helpmyadmin&sel=users&edit=<?=$data["user_id"]; ?>"><?=$data["user"]; ?></td>
		<td align="center"><?=$data["serebro"]; ?></td>
		<td align="center"><?=$data["purse"]; ?></td>
		<td align="center"><?= date("d/m/Y", $data["date_add"]);  ?> </td>
		<td align="center">


			<?php
				switch ($data["status"]){
					case 0:
			?>
						<div class="admin_pay_action_buttons">
							<form class="admin_pay_action_refuse" >
								<input type="hidden" class="admin_pay_action_refuse_return" name="return" value="<?=$data["id"]; ?>" />
								<input type="submit" value="Отказать" />
							</form>

							<form class="admin_pay_action_pay">
								<input type="hidden" class="admin_pay_action_pay_payment" name="payment" value="<?=$data["id"]; ?>" />
								<input type="submit" value="Выплатить" />
							</form>
						</div>
			<?php

					break;
					case 2:
						echo "Отказано";
						break;
					case 3:
						echo "Выплачено";
						break;
					default:
						echo "Выплачивается";
						break;
			}
			?>

		</td>
	</tr>
	<?PHP
	
	}

?>

</table>
<?PHP

}else echo "<center><b>Нет заявок для выплаты</b></center><BR />";

?>
</div>
<div class="clr"></div>
