<?PHP
$_OPTIMIZATION["title"] = "�������";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>

	<div style="font-size: 19px;" class="block_name">���������� �� ��������:</div>
<div style="padding: 5px 15px; width: 480px;">
<table width="100%" class="table_info">
<tbody>
<tr class="tr_line">
	<td width="200px"><span>���������:</span></td>
	<td><b><?=floor($prof_data["insert_sum"]); ?></b> ���.</td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>��������:</span></td>
	<td><b><?=floor($prof_data["payment_sum"]); ?></b> ���.</td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>������ (��� �������):</span></td>
	<td><b><?=floor($prof_data["money_b"]); ?></b> [<a href="/account/balance.html"><font color="blue">���������</font></a>]</td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>������ (�� �����):</span></td>
	<td><b><?=floor($prof_data["money_p"]); ?></b> [<a href="/account/withdraw.html"><font color="blue">�������</font></a>]</td>
</tr>

<tr class="tr_line">
	<td width="200px"><span>���������� �� ���������:</span></td>
	<td><b><?=floor($prof_data["from_referals"]); ?></b> ������</td>
</tr>

</tbody></table>
</div>

	<div style="font-size: 19px;" class="block_name">��������������� ������:</div>
<div style="padding: 5px 15px; width: 480px;">
<table width="100%" class="table_info">
<tbody><tr class="tr_line">
	<td width="200px"><span>���������:</span></td>
	<td><b><?=$prof_data["user"]; ?></b></td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>ID ��������:</span></td>
	<td><b><?=$prof_data["id"]; ?></b></td>

</tr><tr class="tr_line">
	<td width="200px"><span>E-mail:</span></td>
	<td><b><?=$prof_data["email"]; ?></b></td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>���� �����������:</span></td>
	<td><b><?=date("d.m.Y � H:i:s",$prof_data["date_reg"]); ?></b></td>
</tr>
<tr class="tr_line">
	<td width="200px"><span>��� ���������:</span></td>
	<td><b><?=$prof_data["referer"]; ?></b></td>
</tr>
</tbody></table>
</div>

<div style="font-size: 16px;" class="block_img1">
��� ���� ����� ��� ������ ������������ � �������, ����������� ��� ����� ������ �������� ���������, ������, ��������. 
<br>� ������� [<a href="/account/referals.html"><font color="blue">����������� ���������</font></a>] � ��� ����� ����������� <b>10%</b><br>
 �� ����� ���������� ������ ����������, ����� �� �� ��������� � �������� � �� ��������.
</div>

 

</div>
<div class="text_pages_bottom"></div>
</div>	