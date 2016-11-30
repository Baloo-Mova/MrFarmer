<?PHP
$tfstats = time() - 60*60*24;
$db->Query("SELECT 
(SELECT COUNT(*) FROM db_users_a) all_users,
(SELECT SUM(insert_sum) FROM db_users_b) all_insert, 
(SELECT SUM(payment_sum) FROM db_users_b) all_payment, 
(SELECT COUNT(*) FROM db_users_a WHERE date_reg > '$tfstats') new_users,
(SELECT COUNT(*) FROM db_users_a WHERE date_login > '$tfstats') activ_users");
$stats_data = $db->FetchArray();

?>
<div class="container"> 
	<div class="stats">
		<ul>
		    
			<li>
				<span><?=$stats_data["all_users"]; ?></span>
				�������������
			</li>
			<li>
				<span><?=$stats_data["activ_users"]; ?></span>
				�������� �� 24 �.
			</li>
			<li>
				<span><?=$stats_data["new_users"]; ?></span>
				����� �� 24 �.
			</li>
			<li>
				<span><?=intval(((time() - $config->SYSTEM_START_TIME) / 86400 ) +1); ?></span>
              �������� ����       
			</li>
			<li>
				<span>
					<a href="/payments.html"><?=sprintf("%.2f",$stats_data["all_payment"]); ?></a>    
				</span>	
				��������o
			</li>
			<li>
				<span>
					<?=sprintf("%.2f",$stats_data["all_insert"]); ?>   
				</span>	
				������ �������

			</li>

		</ul>
		
	<div class="bantop">	
<table align="center" width="1000"> 
   <td>
   <?php
$banners[1] = '<a href="http://socpublic.com/?i=1421000" target="_blank"><img src="http://socpublic.com/storage/banners/banner_2_468x60.gif" width="468" height="60" border="0" alt="SOCPUBLIC.COM - ��������� � ���������!"></a>';
$banners[2] = '<a href="http://freebitco.in/?r=1537931" target="_blank"><img src="http://static1.freebitco.in/banners/468x60-3.png" width="468" height="60" border="0" alt="������ ������� ����" /></a>';
$banners[3] = '<a href="http://exmo.com/?ref=152898" target="_blank"><img src="http://mr-farmer.biz/img/EXMO.png" width="468" height="60" border="0" alt="������ ����� �����������" /></a>';
$banners[4] = '<a href="http://epay.info/rotator/1386577" target="_blank"><img src="http://mr-farmer.biz/img/bitcoins-free.jpg" width="468" height="60" border="0" alt="������ ������� ������� ������"></a>';
$rnd = rand(1,4);
echo $banners[$rnd];
?>
   </td>
   <td>
  <?php
$banners[1] = '<a href="http://wmrfast.com/?r=308242" target="_blank"><img src="http://wmrfast.com/banners/WF-468.gif" width="468" height="60" border="0" alt="WMRFast - ������ ����� ��� ���������" /></a>';
$banners[2] = '<a href="http://seo-fast.ru/?r=1221685" target="_blank"><img src="http://seo-fast.ru/site_banners/img/banner468x60.gif" width="468" height="60" border="0" alt="����������� ������" /></a>';
$banners[3] = '<a href="https://profitcentr.com/?r=aligattoorr" target="_blank"><img src="https://profitcentr.com/banners/profit9x468x60.gif" width="468" height="60" border="0" alt="ProfitCentr - ��������� ���������"></a>';
$banners[4] = '<a href="http://ru.ifaucet.net/?ref=103444" title="����������� � 500+ ������ �� ����� �����"><img src="http://i1.ru.ifaucet.net/ifaucet.net-468x60ru.gif" alt="����������� � 500+ ������ �� ����� �����"></a>';
$rnd = rand(1,4);
echo $banners[$rnd];
?>
   </td>
</table> 
	</div>
</div>
</div>