<?PHP
$_OPTIMIZATION["title"] = "Пополнение баланса";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];
$db->Query("SELECT * FROM db_config WHERE id = '1'");
$data_c = $db->FetchArray();
$persent = $data_c['ser_per_wmr'];
$fk_merchant_id = '';
$fk_merchant_key = '';

?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>

<?php
if(isset($_POST['pay'])) {
	if(htmlspecialchars($_POST['method']) === 'payeer') {
?>
<div id="error" class="err"></div>
<div class="title aligncenter">Пополнение рекламного счета через <img class="payment_top" height="33" alt="" src="/images/payment/<?=htmlspecialchars($_POST['method']);?>.png"></div>
<div class="line_divider"></div>
	<form method="POST" action="/account/advpayeer.html">
		<div class="adding_funds">
			<div class="add_wrap">
				<input type="hidden" name="adv_id" value="<?php echo $_POST['adv_id']; ?>">
				<input class="input_text w50p" type="text" value="<?php echo $_POST['sum'] / $data_c['ser_per_wmr']; ?>" name="sum" id="sum" onchange="calculate(this.value)" onkeyup="calculate(this.value)" onfocusout="calculate(this.value)" onactivate="calculate(this.value)" ondeactivate="calculate(this.value)">
				<div class="add_curr">RUB</div>
			</div>
			<input class="subm_button topup_button add_wrap_r" id="submit" type="submit" value="Пополнить баланс" >
			<div class="s_divide"></div>
			<div class="clear"></div>

		</div>
	</form>
<script type="text/javascript">
var min = 1;
var ser_pr = <?=$persent;?>;
function calculate(st_q) {

	var sum_insert = parseInt(st_q);
	$('#res_sum').html( (sum_insert * ser_pr) );

	var re = /[^0-9\.]/gi;
    var url = window.location.href;
    var desc = '<?=$usid;?>';
    var sum = $('#sum').val();
    if (re.test(sum)) {
        sum = sum.replace(re, '');
        $('#sum').val(sum);
    }
    if (sum < min) {
        $('#error').html('Сумма должна быть больше '+min);
		$('#error').css("display","block");
		$('#submit').attr("disabled", "disabled");
        return false;
    } else {
        $('#error').html('');
		$('#error').css("display","none");
    }

    $.get('/free-kassa-data.php?prepare_once=1&l='+desc+'&oa='+sum, function(data) {
         var re_anwer = /<hash>([0-9a-z]+)<\/hash>/gi;
         $('#s').val(re_anwer.exec(data)[1]);
         $('#submit').removeAttr("disabled");
    });
}

calculate(100);
</script>
</div>
<div class="text_pages_bottom"></div>
</div>
<?php
} elseif (
			htmlspecialchars($_POST['method']) === 'fk_qiwi'         ||
			htmlspecialchars($_POST['method']) === 'fk_ooopay' 		 ||
			htmlspecialchars($_POST['method']) === 'fk_payeer' 		 ||
			htmlspecialchars($_POST['method']) === 'fk_okpay' 		 ||
			htmlspecialchars($_POST['method']) === 'fk_perfectmoney' ||
			htmlspecialchars($_POST['method']) === 'fk_egopay' 		 ||
			htmlspecialchars($_POST['method']) === 'fk_megafon' 	 ||
			htmlspecialchars($_POST['method']) === 'fk_mts' 		 ||
			htmlspecialchars($_POST['method']) === 'fk_visa' 		 ||
			htmlspecialchars($_POST['method']) === 'fk_mastercard'

		)
{
$rest = substr(htmlspecialchars($_POST['method']), 3);
?>
<div id="error" class="err"></div>
<div class="title aligncenter">Пополнение счёта через <img class="payment_top" height="33" alt="" src="/images/payment/<?=$rest;?>.png"></div>
<div class="line_divider"></div>
<form method=GET action="http://www.free-kassa.ru/merchant/cash.php">
<div class="adding_funds">
<div class="add_wrap">
<input type="hidden" name="m" value="<?=$fk_merchant_id?>">
<input class="input_text w50p" type="text" name="oa" id="sum" value="100" size="7" id="oa" onchange="calculate(this.value)" onkeyup="calculate(this.value)" onfocusout="calculate(this.value)" onactivate="calculate(this.value)" ondeactivate="calculate(this.value)">
<div class="add_curr">RUB</div>
</div>
<input class="subm_button topup_button add_wrap_r" type="submit" id="submit" value="Пополнить баланс" >
<input type="hidden" name="s" id="s" value="0">
<input type="hidden" name="us_id" id="us_id" value="<?=$usid;?>">
<input type="hidden" name="o" id="desc" value="<?=$usid;?>" />
<div class="s_divide"></div>
<div class="clear"></div>
<center>
<div class="already_got"><img src="/images/success.png">&nbsp; Вы получите:</div>
</center>
<div class="s_divide"></div>
<div id="rfVal" class="bonus_w">
<div class="left_b"><span id="res_sum"></span></div> <img class="b_icon left" src="/images/gold.png">
</div>
</div>
</form>



</div>
<div class="text_pages_bottom"></div>
</div>
<script type="text/javascript">
var min = 1;
var ser_pr = <?=$persent;?>;
function calculate(st_q) {

	var sum_insert = parseInt(st_q);
	$('#res_sum').html( (sum_insert * ser_pr) );

	var re = /[^0-9\.]/gi;
    var url = window.location.href;
    var desc = '<?=$usid;?>';
    var sum = $('#sum').val();
    if (re.test(sum)) {
        sum = sum.replace(re, '');
        $('#oa').val(sum);
    }
    if (sum < min) {
        $('#error').html('Сумма должна быть больше '+min);
		$('#error').css("display","block");
		$('#submit').attr("disabled", "disabled");
        return false;
    } else {
        $('#error').html('');
		$('#error').css("display","none");
    }

    $.get('/free-kassa-data.php?prepare_once=1&l='+desc+'&oa='+sum, function(data) {
         var re_anwer = /<hash>([0-9a-z]+)<\/hash>/gi;
         $('#s').val(re_anwer.exec(data)[1]);
         $('#submit').removeAttr("disabled");
    });
}

calculate(100);
</script>
<?php } else { ?>
<div class='err'>Выберите метод платежа!</div>
</div>
<div class="text_pages_bottom"></div>
</div>
<?php
}
return; }
?>

<?php
$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

if(isset($_POST["sum"])){

$sum = round(floatval($_POST["sum"]),2);
$adv_id = $_POST["adv_id"];

# Заносим в БД
$db->Query("INSERT INTO db_payeer_insert (user_id, user, sum, date_add, adv_id) VALUES ('".$_SESSION["user_id"]."','".$_SESSION["user"]."','$sum','".time()."','$adv_id')");

$desc = base64_encode($_SERVER["HTTP_HOST"]." - USER ".$_SESSION["user"]);
$m_shop = $config->shopID;
$m_orderid = $db->LastInsert();
$m_amount = number_format($sum, 2, ".", "");
$m_curr = "RUB";
$m_desc = $desc;
$m_key = $config->secretW;

$arHash = array(
 $m_shop,
 $m_orderid,
 $m_amount,
 $m_curr,
 $m_desc,
 $m_key
);
$sign = strtoupper(hash('sha256', implode(":", $arHash)));

?>
<div class="title aligncenter">Подтверждение оплаты счёта</div>
<center>
Итого к оплате: <?=number_format($sum, 2, ".", "")?> RUB
</center>
<div class="line_divider"></div>
<center>
<form method="GET" action="//payeer.com/api/merchant/m.php">
	<div>
	<input type="hidden" name="m_shop" value="<?=$config->shopID; ?>">
	<input type="hidden" name="m_orderid" value="<?=$m_orderid; ?>">
	<input type="hidden" name="m_amount" value="<?=number_format($sum, 2, ".", "")?>">
	<input type="hidden" name="m_curr" value="RUB">
	<input type="hidden" name="m_desc" value="<?=$desc; ?>">
	<input type="hidden" name="m_sign" value="<?=$sign; ?>">
	<input type="submit" name="m_process" value="Перейти к оплате счета" />
	</div>
</form>
</center>
</div>
<div class="text_pages_bottom"></div>
</div>
<?php 
return;
}
?>

	<div class="s_divide"></div>
	<div class="clear"></div>
	<div class="line_divider"></div>
<center>    
	<div class="already_got">Пополнение через <a target="_blank" href="http://payeer.com/01350612" class="tips" original-title="Перейти на сайт">Payeer Merchant</a></div>
</center>
<div class="line_divider"></div>

<div class="payment_m">
	<label for="payment_payeer">
		<div class="p_logo">
			<img height="33" alt="" src="/images/payment/payeer.png">
		</div>
	</label>
	<form method="post" action="">
		<input type="hidden" name="method" value="payeer">
		<input type="submit" class="p_button" name="pay" value="Payeer">
	</form>
</div>


</div>
<div class="text_pages_bottom"></div>
</div>
