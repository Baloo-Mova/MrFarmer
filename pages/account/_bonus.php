<?PHP
$_OPTIMIZATION["title"] = "Ежедневный бонус";
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];

# Настройки бонусов
$bonus_min = 1;
$bonus_max = 20;

?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<center>
	<div class="bonuses">
		<p>Бонус выдается 1 раз в 24 часа</p>
		<p>Бонус выдается золотом на счет для покупок. Сумма бонуса генерируется от 1 до 20 монет.</p>
	</div>
<?PHP
$ddel = time() + 60*60*24;
$dadd = time();
$db->Query("SELECT * FROM db_bonus_list WHERE user_id = '$usid'");
$row = $db->FetchArray();



$db->Query("SELECT COUNT(*) FROM db_bonus_list WHERE user_id = '$usid' AND date_del > '$dadd'");
$hide_form = false;



	if($db->FetchRow() == 0){
	
		# Выдача бонуса
		if(isset($_POST["bonus"])){
		
			$sum = rand($bonus_min, rand($bonus_min, $bonus_max) );
			
			# Зачилсяем юзверю
			$db->Query("UPDATE db_users_b SET money_b = money_b + '$sum' WHERE id = '$usid'");
			
			# Вносим запись в список бонусов
			
			
			$db->Query("INSERT INTO db_bonus_list (user, user_id, sum, date_add, date_del) VALUES ('$uname','$usid','$sum','$dadd','$ddel')");
			
			# Случайная очистка устаревших записей
			$db->Query("DELETE FROM db_bonus_list WHERE date_del < '$dadd'");
			echo "<div class='ok'>На Ваш счет для покупок зачислен бонус в размере {$sum}!</div>";
			$hide_form = true;
			
		}
			
			# Показывать или нет форму
			if(!$hide_form){
?>

<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="bonus" value="Получить бонус" style="height: 30px; margin-top:10px;"></td>
  </tr>
</table>
</form>

<?PHP 

			}

	}else echo '<div class="already_got"><img src="../images/success.png">&nbsp; Вы уже получали бонус за последние 24 часа</div>
	<div class="time_to">Вы можете получить Ваш бонус через: <span style="color:#a20003;">'.$func->secs2hours($row["date_del"] - $dadd).'</span></div>
	'; ?>




<table style="width: 100%">
<tr>
	<th class="paddingtableb" width="10%">ID</th>
	<th class="paddingtableb" width="45%">Пользователь</th>
	<th class="paddingtableb" width="20%">Всего</th>
	<th class="paddingtableb" width="25%">Дата</th>
</tr>
  <?PHP
  
  $db->Query("SELECT * FROM `db_bonus_list` ORDER BY `id` DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($bon = $db->FetchArray()){
		
		?>
		<tr>
    		<th class="paddingtablesmall"><?=$bon["id"]; ?></th>
    		<th class="paddingtablesmall"><?=$bon["user"]; ?></th>
    		<th class="paddingtablesmall"><?=$bon["sum"]; ?></th>
			<th class="paddingtablesmall"><?=date("d.m.Y",$bon["date_add"]); ?></th>
  		</tr>
		<?PHP
		
		}
  
	}else echo "<div class='ok'>Записай не найдено!</div>"
  ?>

  
</table>
<center>
</div>
<div class="text_pages_bottom"></div>
</div>




