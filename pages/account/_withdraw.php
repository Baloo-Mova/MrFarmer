<?PHP
$_OPTIMIZATION["title"] = "F.A.Q. - ������-�����";
$_OPTIMIZATION["description"] = "������ - �����";
$_OPTIMIZATION["keywords"] = "���������� �� ����. �������� ������� �������.";
?>
<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content"> </div>
<div class="text_pages_content">
<div class="title_r"><center>����� �������</center></div>

<?PHP
$_OPTIMIZATION["title"] = "������� - ����� �������";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

$status_array = array( 0 => "��������������", 1 => "�������������", 2 => "��������", 3 => "���������");

# ��������� ��������!
$minPay = $sonfig_site["minPay"];
$maxPay = $sonfig_site["maxPay"];

function ViewPurse($purse){

if( substr($purse,0,1) != "P" ) return false;
if( !preg_match("/^[0-9]{7,8}$/", substr($purse,1)) ) return false; 
return $purse;
}

function autoPay($config, $sum, $sonfig_site, $purse, $db, $usname, $usid){

	### ������ ������� ###
	$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
	if ($payeer->isAuth())
	{

		$arBalance = $payeer->getBalance();
		if($arBalance["auth_error"] == 0)
		{

			$sum_pay = round( ($sum / $sonfig_site["ser_per_wmr"]), 2);

			$balance = $arBalance["balance"]["RUB"]["DOSTUPNO"];
			if( ($balance) >= ($sum_pay)){



				$arTransfer = $payeer->transfer(array(
					'curIn' => 'RUB', // ���� ��������
					'sum' => $sum_pay, // ����� ���������
					'curOut' => 'RUB', // ������ ���������
					'to' => $purse, // ���������� (email)
					//'to' => '+71112223344',  // ���������� (�������)
					//'to' => 'P1000000',  // ���������� (����� �����)
					'comment' => iconv('windows-1251', 'utf-8', "������� ������������ {$usname} � ������� MR-Farmer")
					//'anonim' => 'Y', // ��������� �������
					//'protect' => 'Y', // ��������� ������
					//'protectPeriod' => '3', // ������ ��������� (�� 1 �� 30 ����)
					//'protectCode' => '12345', // ��� ���������
				));

				if (!empty($arTransfer["historyId"]))
				{


					# ������� � ������������
					$db->Query("UPDATE db_users_b SET money_p = money_p - '$sum' WHERE id = '$usid'");

					# ��������� ������ � �������
					$da = time();
					$dd = $da + 60*60*24*15;

					$ppid = $arTransfer["historyId"];

					$db->Query("INSERT INTO db_payment (user, user_id, purse, sum, valuta, serebro, payment_id, date_add, status) 
											VALUES ('$usname','$usid','$purse','$sum_pay','RUB', '$sum','$ppid','".time()."', '3')");

					$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$sum_pay' WHERE id = '$usid'");
					$db->Query("UPDATE db_stats SET all_payments = all_payments + '$sum_pay' WHERE id = '1'");

					return "<center><font color = 'green'><b>���������!</b></font></center><BR />";

				}
				else
				{
					return "<center><font color = 'red'><b>��������� ������ - �������� � ��� ��������������!</b></font></center><BR />";
				}

			}else{
				return "<center><font color = 'red'><b>��������� ������ - �������� � ��� ��������������!</b></font></center><BR />";
			}

		}else{
			return "<center><font color = 'red'><b>�� ������� ���������! ���������� �����</b></font></center><BR />";
		}

	}else{
		return "<center><font color = 'red'><b>�� ������� ���������! ���������� �����</b></font></center><BR />";
	}
}

function manualPay($db, $usname, $usid, $purse, $sum, $sonfig_site){
	# ��������� ������ � �������
	$da = time();
	$dd = $da + 60*60*24*15;

	$ppid = 0;

	$sum_pay = round( ($sum / $sonfig_site["ser_per_wmr"]), 2);

	$db->Query("INSERT INTO db_payment (user, user_id, purse, sum, valuta, serebro, payment_id, date_add, status) 
											VALUES ('$usname','$usid','$purse','$sum_pay','RUB', '$sum','$ppid','".time()."', '0')");
}

	$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$usid' AND status = '2' ORDER BY date_add DESC LIMIT 1");
	if($db->FetchRow() > 0){
		echo "<center><b><font color = 'red'>��� ��������� ������� ������ ��������� � ��������������� � ������� <a href='http://mr-farmer.biz/contacts.html'>��������</a></font></b></center><BR />";
	}

	# ������� �������
	if(isset($_POST["purse"])){
	$_POST["purse"] = $db->RealEscape($_POST['purse']);
	
		$purse = ViewPurse($_POST["purse"]);
		$purse = $db->RealEscape($_POST['purse']);
		$sum = intval($_POST["sum"]);
		$sum = $db->RealEscape($_POST['sum']);
		$val = "RUB";

		if($purse !== false){

			// ��������� �� ������������ ������
			$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$usid' AND (status = '0' OR status = '1')");
			if($db->FetchRow() == 0){

				if($sum >= $minPay){

					// ��������� ������� ������� ������ ����� ������� �������
					$db->Query("SELECT * FROM db_payment WHERE user_id = '$usid' AND status = '3' ORDER BY date_add DESC LIMIT 1");
					$last_pay = $db->FetchArray();
					$date = new DateTime();
					$now_date_time = $date->getTimestamp();
					$gone_time = $now_date_time - $last_pay['date_add'];

					if($db->NumRows() == 0){
						if($sum <= $maxPay){
							echo autoPay($config, $sum, $sonfig_site, $purse, $db, $usname, $usid);
						}else{
							manualPay($db, $usname, $usid, $purse, $sum, $sonfig_site);
							echo "<center><b><font color ='red'>������������ ����� ��� ������� ���������� {$maxPay} �����! ���� ������ ������� � ����� ���������� � ������ ������!</font></b></center><BR />";
						}
					}else{
						if($gone_time < 86400){
							manualPay($db, $usname, $usid, $purse, $sum, $sonfig_site);
							echo "<center><b><font color = 'red'>�������������� ������� �������� ��� � �����! ���� ������ ������� � ����� ���������� � ������ ������!</font></b></center><BR />";
						}else{
							if($sum <= $maxPay){
								echo autoPay($config, $sum, $sonfig_site, $purse, $db, $usname, $usid);
							}else{
								manualPay($db, $usname, $usid, $purse, $sum, $sonfig_site);
								echo "<center><b><font color ='red'>������������ ����� ��� ������� ���������� {$maxPay} �����! ���� ������ ������� � ����� ���������� � ������ ������!</font></b></center><BR />";
							}
						}
					}

				}else {
					echo "<center><b><font color = 'red'>����������� ����� ��� ������� ���������� {$minPay} �����!</font></b></center><BR />";
				}
			}else{
				echo "<center><font color = 'red'><b>� ��� ���� �������������� ������, ��������� �������!</b></font></center><BR />";
			}

		}else{
			echo "<center><b><font color ='red'>������� Payeer ������ �������! �������� �������!</font></b></center><BR />";
		}

	}
?>

	<div class="webmoney_left">        
<form id="cashout" action="" method="post">
<div class="inp_wrap">
<label>�������</label>
<input class="input_text w340" type="text" required="" placeholder="PAYEER ID" value="" name="purse">
</div>

<div class="inp_wrap">
<label>������ ��� ������ [���. <span id="res_min"><?= $minPay ?></span>]:</label>
<input id="sum" class="input_text w340" type="number" autocomplete="off" max="50000" min="<?= $minPay ?>" value="<?=round($user_data["money_p"]); ?>" name="sum" onkeyup="PaymentSum();" />
</div>
<div class="withdraw_wrap">

<div class="w_t" <div id="res_sum">0</div><div class="w_c">RUB</div> 
</div>
 	
<input type="hidden" name="per" id="RUB" value="<?=$sonfig_site["ser_per_wmr"]; ?>" disabled="disabled"/>
<input type="hidden" name="per" id="min_sum_RUB" value="1" disabled="disabled"/>
<input type="hidden" name="val_type" id="val_type" value="RUB" />
<input class="subm_button" type="submit" name="swap" value="�������� �������"/>
</form>
	</div>
	<div class="webmoney_right">
		Payeer ������������ ����� ������������� �������� ������, ������������������� �� �������, ������������ �������� ������ � �������� ������� ������������.  
		��������� ������� Payeer  ������ ����������� � ��������� �����, ������� ����� �� ����� ���� (��� ������ ����� �������, ��� � �� ������� �����), 
		����� ����������� ����� ��� ����� � ����������� ��������� �� �������� &mdash; ��� ���� ����� ����� ������������, ������� ������������� Payeer.
	</div>
<script language="javascript">PaymentSum(); SetVal();</script>



<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><h4>��������� 10 ������</h4></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">�������</td>
    <td align="center" class="m-tb">���������</td>
	<td align="center" class="m-tb">�������</td>
	<td align="center" class="m-tb">����</td>
	<td align="center" class="m-tb">������</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM db_payment WHERE user_id = '$usid' ORDER BY id DESC LIMIT 10");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
		?>
		<tr class="htt">
    		<td align="center"><?=$ref["serebro"]; ?></td>
    		<td align="center"><?=sprintf("%.2f",$ref["sum"] - $ref["comission"]); ?> <?=$ref["valuta"]; ?></td>
    		<td align="center"><?=$ref["purse"]; ?></td>
			<td align="center"><?=date("d.m.Y",$ref["date_add"]); ?></td>
    		<td align="center"><?=$status_array[$ref["status"]]; ?></td>
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">��� �������</td></tr>'
  
  ?>

  
</table>	
</div>
<div class="text_pages_bottom"></div>
</div>
