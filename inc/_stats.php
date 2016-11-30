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
				Пользователей
			</li>
			<li>
				<span><?=$stats_data["activ_users"]; ?></span>
				Активных за 24 ч.
			</li>
			<li>
				<span><?=$stats_data["new_users"]; ?></span>
				Новых за 24 ч.
			</li>
			<li>
				<span><?=intval(((time() - $config->SYSTEM_START_TIME) / 86400 ) +1); ?></span>
              Работаем дней       
			</li>
			<li>
				<span>
					<a href="/payments.html"><?=sprintf("%.2f",$stats_data["all_payment"]); ?></a>    
				</span>	
				Выплаченo
			</li>
			<li>
				<span>
					<?=sprintf("%.2f",$stats_data["all_insert"]); ?>   
				</span>	
				Резерв проекта

			</li>

		</ul>
		
	<div class="bantop">	
<table align="center" width="1000"> 
   <td>
   <?php
$banners[1] = '<a href="http://socpublic.com/?i=1421000" target="_blank"><img src="http://socpublic.com/storage/banners/banner_2_468x60.gif" width="468" height="60" border="0" alt="SOCPUBLIC.COM - заработок в интернете!"></a>';
$banners[2] = '<a href="http://freebitco.in/?r=1537931" target="_blank"><img src="http://static1.freebitco.in/banners/468x60-3.png" width="468" height="60" border="0" alt="Лучший биткоин кран" /></a>';
$banners[3] = '<a href="http://exmo.com/?ref=152898" target="_blank"><img src="http://mr-farmer.biz/img/EXMO.png" width="468" height="60" border="0" alt="Лучшая биржа криптовалют" /></a>';
$banners[4] = '<a href="http://epay.info/rotator/1386577" target="_blank"><img src="http://mr-farmer.biz/img/bitcoins-free.jpg" width="468" height="60" border="0" alt="Лучший ротатор биткоин кранов"></a>';
$rnd = rand(1,4);
echo $banners[$rnd];
?>
   </td>
   <td>
  <?php
$banners[1] = '<a href="http://wmrfast.com/?r=308242" target="_blank"><img src="http://wmrfast.com/banners/WF-468.gif" width="468" height="60" border="0" alt="WMRFast - лучшее место для заработка" /></a>';
$banners[2] = '<a href="http://seo-fast.ru/?r=1221685" target="_blank"><img src="http://seo-fast.ru/site_banners/img/banner468x60.gif" width="468" height="60" border="0" alt="Реферальные банеры" /></a>';
$banners[3] = '<a href="https://profitcentr.com/?r=aligattoorr" target="_blank"><img src="https://profitcentr.com/banners/profit9x468x60.gif" width="468" height="60" border="0" alt="ProfitCentr - рекламное агентство"></a>';
$banners[4] = '<a href="http://ru.ifaucet.net/?ref=103444" title="Зарабатывай с 500+ кранов на одном сайте"><img src="http://i1.ru.ifaucet.net/ifaucet.net-468x60ru.gif" alt="Зарабатывай с 500+ кранов на одном сайте"></a>';
$rnd = rand(1,4);
echo $banners[$rnd];
?>
   </td>
</table> 
	</div>
</div>
</div>