<div class="s-bk-lf">
	<div class="acc-title">Платежные системы</div>
</div>
<div class="silver-bk"><div class="clr"></div>	

<center><a href = "/?menu=admin4ik&sel=pay_systems" class="stn">Список систем</a> || <a href = "/?menu=admin4ik&sel=pay_systems&add" class="stn">Добавить систему</a></center>
<BR />
<?PHP
if(isset($_POST["del"])){

$ret_id = intval($_POST["del"]);

$db->Query("DELETE FROM db_pay_systems WHERE id = '$ret_id'");
	
	echo "<center><b>Платежная система удалена</b></center><BR />";

}

# добавление платежки
if(isset($_GET["add"])){

	if(isset($_POST["title"], $_SESSION["add_sys"]) AND $_SESSION["add_sys"] == $_POST["add_sys"]){
	
	unset($_SESSION["add_sys"]);
	
	$title = $func->TextClean($_POST["title"]);
	$comment = $func->TextClean($_POST["comment"]);
	$min_pay = intval($_POST["min_pay"]);
	$first_char = strtoupper($_POST["first_char"]);
	
		if(strlen($title) >= 3){
		
			if(strlen($comment) >= 30){
			
				if($min_pay > 0){
				
					$db->Query("INSERT INTO db_pay_systems (title, first_char, comment, min_pay) VALUES ('$title','$first_char','$comment','$min_pay')");
					
					echo "<center><b><font color = 'green'>Платежная система добавлена</font></b></center><BR /></div><div class='clr'></div>	";
					return;
				}else echo "<center><b><font color = 'red'>Минимальная сумма к выплате не может быть менее 1 {$config->VAL}</font></b></center><BR />";
			
			}else echo "<center><b><font color = 'red'>Комментарий к платежной системе не может быть менее 30 символов</font></b></center><BR />";
			
		}else echo "<center><b><font color = 'red'>Заголовк не может быть менее 3х символов</font></b></center><BR />";
	
	}

?>

<form action="" method="post">
<b>Заголовок (максимум 100 символов):</b><BR />
<input type="text" name="title" size="45" value="<?=(isset($_POST["title"])) ? $_POST["title"] : false; ?>" /><BR /><BR />
<b>Первая буква кошелька:</b><BR />
<input type="text" name="first_char" size="5" value="<?=(isset($_POST["first_char"])) ? $_POST["first_char"] : false; ?>" /> (Например для WMZ первая буква Z)<BR /><BR />
<b>Минималка (<?=$config->VAL; ?>):</b><BR />
<input type="text" name="min_pay" size="5" value="<?=(isset($_POST["min_pay"])) ? $_POST["min_pay"] : false; ?>" /> (Допускаются только целые числа)<BR /><BR />
<b>Комментарий (Например, описание платежки) (До 100 символов):</b><BR />
<textarea name="comment" cols="75" rows="25"><?=$_POST["comment"]; ?></textarea><BR /><BR />
<center><input type="submit" value="Создать" /></center>
<?PHP
$_SESSION["add_sys"] = rand(1,1000);
?>
<input type="hidden" name="add_sys" value="<?=$_SESSION["add_sys"]; ?>" />

</form>
</div>
<div class="clr"></div>	
<?PHP
return;
}

$db->Query("SELECT * FROM db_pay_systems ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" width="50" class="m-tb">ID</td>
    <td align="center" class="m-tb">Название</td>
	<td align="center" class="m-tb">Начинается с</td>
	<td align="center" class="m-tb">Минималка</td>
	<td align="center" width="70" class="m-tb">Удалить</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["title"]; ?></td>
	<td align="center"><?=$data["first_char"]; ?></td>
	<td align="center"><?=$data["min_pay"]; ?></td>
	<td align="center" width="70">
	<form action="" method="post">
	<input type="hidden" name="del" value="<?=$data["id"]; ?>" />
	<input type="submit" value="Удалить" />
	</form>
	</td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<?PHP

}else echo "<center><b>Платежных систем нет</b></center><BR />";
?>
</div>
<div class="clr"></div>	