<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">	
<?PHP

$db->Query("SELECT 
	COUNT(id) all_users, 
	SUM(money_b) money_b, 
	SUM(money_p) money_p, 
	
	SUM(a_t) a_t, 
	SUM(b_t) b_t, 
	SUM(c_t) c_t, 
	SUM(d_t) d_t, 
	SUM(e_t) e_t, 
	
	SUM(a_b) a_b, 
	SUM(b_b) b_b, 
	SUM(c_b) c_b, 
	SUM(d_b) d_b, 
	SUM(e_b) e_b, 
	
	SUM(all_time_a) all_time_a, 
	SUM(all_time_b) all_time_b, 
	SUM(all_time_c) all_time_c, 
	SUM(all_time_d) all_time_d, 
	SUM(all_time_e) all_time_e,
	
	SUM(payment_sum) payment_sum, 
	SUM(insert_sum) insert_sum
	
	
	FROM db_users_b");
$data_stats = $db->FetchArray();

?>
<?
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];
	if ($_POST[fals_pay] != '' AND $_POST[usn] != '' AND $_POST[usi] != '') {
# ��������� ������ � �������
$da = time();
$dd = $da + 60*60*24*15;
$sum_r = round($_POST[fals_pay], 2);
$db->Query("INSERT INTO db_payment (user, user_id, sum, pay_sys, date_add, date_del, status) VALUES ('$_POST[usn]','$_POST[usi]','$sum_r','$sum','$da','$dd','3')");
$db->Query("UPDATE db_stats SET all_payments = all_payments + '$_POST[fals_pay]' WHERE id = '1'");
$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$_POST[fals_pay]' WHERE id = '$_POST[usi]'");
}
?>
<table width="450" border="0" align="center">

  <tr class="htt">
    <td><b>��������� �������: </b></td>
	<td width="100" align="center">
	<form method="post">
	<input type="text" name="fals_pay" placeholder="����� �������">
	<input type="text" name="usn" placeholder="name user">
	<input type="text" name="usi" placeholder="id user">
	<input type="submit" value="���������">
	</form></td>
  </tr>

  <tr class="htt">
    <td><b>���������������� �������������:</b></td>
	<td width="100" align="center"><?=$data_stats["all_users"]; ?> ���.</td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>�� ������ (��� �������):</b></td>
	<td width="100" align="center"><?=sprintf("%.0f",$data_stats["money_b"]); ?></td>
  </tr>
  
  <tr class="htt">
    <td><b>�� ������ (�� �����):</b></td>
	<td width="100" align="center"><?=sprintf("%.0f",$data_stats["money_p"]); ?></td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>������� �����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["a_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� ������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["b_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� ����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["c_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� ���:</b></td>
	<td width="100" align="center"><?=intval($data_stats["d_t"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� �����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["e_t"]); ?> ��.</td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>�� ������� ���:</b></td>
	<td width="100" align="center"><?=intval($data_stats["a_b"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>�� ������� ����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["b_b"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>�� ������� ������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["c_b"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>�� ������� ������ ����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["d_b"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>�� ������� ������ ������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["e_b"]); ?> ��.</td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>������� �� ��� ����� ���:</b></td>
	<td width="100" align="center"><?=intval($data_stats["all_time_a"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� �� ��� ����� ����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["all_time_b"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� �� ��� ����� ������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["all_time_c"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� �� ��� ����� ������ ����:</b></td>
	<td width="100" align="center"><?=intval($data_stats["all_time_d"]); ?> ��.</td>
  </tr>
  
  <tr class="htt">
    <td><b>������� �� ��� ����� ������ ������:</b></td>
	<td width="100" align="center"><?=intval($data_stats["all_time_e"]); ?> ��.</td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr class="htt">
    <td><b>������� ��������������:</b></td>
	<td width="100" align="center"><?=sprintf("%.2f",$data_stats["insert_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr class="htt">
    <td><b>��������� �������������:</b></td>
	<td width="100" align="center"><?=sprintf("%.2f",$data_stats["payment_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
</table>

</div>
<div class="text_pages_bottom"></div>
</div>