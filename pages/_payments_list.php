<?PHP
$_OPTIMIZATION["title"] = "��������� �������";
$_OPTIMIZATION["description"] = "������ ��������� ������";
$_OPTIMIZATION["keywords"] = "��������� �������";
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
<center>
	<div class="title_r">
		<p>������ ��������� 50 ������</p>
	</div>
</center>
<?PHP

$dt = time() - 60*60*48;

$db->Query("SELECT * FROM db_payment WHERE status = '3' ORDER BY `id` DESC LIMIT 50");



if($db->NumRows() > 0){

$all_pay = 0;
$all_pay_sum = 0;

?>
<table width="99%">
	<tr>
		<th class="paddingtableb" width="5%">ID</th>
		<th class="paddingtableb" width="25%">������������</th>
		<th class="paddingtableb" width="27%">�����</th>
		<th class="paddingtableb" width="8%">������</th>
		<th class="paddingtableb" width="25%">����</th>
	</tr>


<?PHP

	while($data = $db->FetchArray()){
	$all_pay ++;
	$all_pay_sum += $data["sum"];
	?>
	<tr>
	<th class="paddingtable"><?=$data["id"]; ?></th>
	<th class="paddingtable"><?=substr($data["user"],0,-3); ?>***</th>
	<th class="paddingtable"><?=sprintf("%.2f",$data["sum"]); ?> <?=$data["valuta"]; ?></th>
	<th class="paddingtable"><img width="50" style="position:absolute;margin:-15px 0px 0px -25px;" alt="" src="/images/payment/payeer.png"></th>
	<th class="paddingtable"><?=date("d M Y H:i",$data["date_add"]); ?></th>
	</tr>
	<?PHP
	
	}

?>
</table>
<?PHP


}else echo "<div class='err'>������ �� �������!</div>";


?>
<div class="s_divide"></div>
</div>
<div class="text_pages_bottom"></div>
</div>	