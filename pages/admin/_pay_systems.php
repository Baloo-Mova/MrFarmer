<div class="s-bk-lf">
	<div class="acc-title">��������� �������</div>
</div>
<div class="silver-bk"><div class="clr"></div>	

<center><a href = "/?menu=admin4ik&sel=pay_systems" class="stn">������ ������</a> || <a href = "/?menu=admin4ik&sel=pay_systems&add" class="stn">�������� �������</a></center>
<BR />
<?PHP
if(isset($_POST["del"])){

$ret_id = intval($_POST["del"]);

$db->Query("DELETE FROM db_pay_systems WHERE id = '$ret_id'");
	
	echo "<center><b>��������� ������� �������</b></center><BR />";

}

# ���������� ��������
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
					
					echo "<center><b><font color = 'green'>��������� ������� ���������</font></b></center><BR /></div><div class='clr'></div>	";
					return;
				}else echo "<center><b><font color = 'red'>����������� ����� � ������� �� ����� ���� ����� 1 {$config->VAL}</font></b></center><BR />";
			
			}else echo "<center><b><font color = 'red'>����������� � ��������� ������� �� ����� ���� ����� 30 ��������</font></b></center><BR />";
			
		}else echo "<center><b><font color = 'red'>�������� �� ����� ���� ����� 3� ��������</font></b></center><BR />";
	
	}

?>

<form action="" method="post">
<b>��������� (�������� 100 ��������):</b><BR />
<input type="text" name="title" size="45" value="<?=(isset($_POST["title"])) ? $_POST["title"] : false; ?>" /><BR /><BR />
<b>������ ����� ��������:</b><BR />
<input type="text" name="first_char" size="5" value="<?=(isset($_POST["first_char"])) ? $_POST["first_char"] : false; ?>" /> (�������� ��� WMZ ������ ����� Z)<BR /><BR />
<b>��������� (<?=$config->VAL; ?>):</b><BR />
<input type="text" name="min_pay" size="5" value="<?=(isset($_POST["min_pay"])) ? $_POST["min_pay"] : false; ?>" /> (����������� ������ ����� �����)<BR /><BR />
<b>����������� (��������, �������� ��������) (�� 100 ��������):</b><BR />
<textarea name="comment" cols="75" rows="25"><?=$_POST["comment"]; ?></textarea><BR /><BR />
<center><input type="submit" value="�������" /></center>
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
    <td align="center" class="m-tb">��������</td>
	<td align="center" class="m-tb">���������� �</td>
	<td align="center" class="m-tb">���������</td>
	<td align="center" width="70" class="m-tb">�������</td>
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
	<input type="submit" value="�������" />
	</form>
	</td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<?PHP

}else echo "<center><b>��������� ������ ���</b></center><BR />";
?>
</div>
<div class="clr"></div>	