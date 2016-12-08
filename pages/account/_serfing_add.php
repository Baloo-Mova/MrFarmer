<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*
 * ������� ��� �����
 * ������: 1.00
 * SKYPE: sereega393
 * ������������� ��� ������ ���������!!!
*/
define('TIME', time());

define('SERF_PRICE', 10); //����������� ��������� ���������
define('SERF_PRICE_TIMER', 0.2); //��������� �������
define('SERF_PRICE_MOVE', 0.8); //��������� ������������ �������� �� ����
define('SERF_PRICE_HIGH', 0.5); //��������� ��������� ������
define('SERF_PRICE_TARGET', 1.2); //��������� ����������


header("Content-Type: text/html; charset=windows-1251");
$msg = '';

$db->Query("SELECT * FROM db_users_b WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchArray();
?>




<div class="text_right">

<link rel="stylesheet" href="/style/main.css" type="text/css" />
<?php

//������ ��� ����� (�� ���������)
$title = '';
$desc = '';
$url = 'http://';
$timer = 20;
$move = 0;
$high = 0;
$speed = 1;
$rating = 0;
$crev = 0;
    
$country1 = 'xx';
$country2 = 'xx';
$country3 = 'xx';
$country4 = 'xx';
$country5 = 'xx';

$advedit = isset($_GET['advedit']) ? (int)$_GET['advedit'] : 0; 

$user_name = $_SESSION['user'];

if (!$advedit && isset($_POST['ask_editcode'])) { $advedit = (int)$_POST['ask_editcode']; }

//print_r($_GET);

if ($advedit)
{  
  if (isset($_SESSION['admin'])) 
  {
    $db->query("SELECT * FROM  db_serfing WHERE id = '".$advedit."' LIMIT 1");
  } 
  else
  { 
    $db->query("SELECT * FROM  db_serfing WHERE id = '".$advedit."' and user_name = '".$user_name."' LIMIT 1");
  }
    
  if ($db->NumRows())
  {
    $result = $db->FetchArray();    
    
    //����������� ������ �� �� ��� ����� ��������������
    $title = $result['title'] ? $result['title'] : '';
    $desc = $result['desc'] ? $result['desc'] : '';
    $url = $result['url'] ? $result['url'] : '';   
    $timer = $result['timer'] ? $result['timer'] : 20;
    $move = $result['move'] ? $result['move'] : 0;
    $high = $result['high'] ? $result['high'] : 0;
    $speed = $result['speed'] ? $result['speed'] : 1;
    $rating = $result['rating'] ? $result['rating'] : 0;
    $crev = $result['crev'] ? $result['crev'] : 0;
    $status = $result['status'];
    
    $country = explode('|', $result['country']);
    
    $country1 = isset($country['0']) && $country['0'] ? $country['0'] : 'xx';
    $country2 = isset($country['1']) && $country['1'] ? $country['1'] : 'xx';
    $country3 = isset($country['2']) && $country['2'] ? $country['2'] : 'xx';
    $country4 = isset($country['3']) && $country['3'] ? $country['3'] : 'xx';
    $country5 = isset($country['4']) && $country['4'] ? $country['4'] : 'xx';
  } 
  else 
  {
    exit();
  }
} 

if (isset($_POST['ask_title']))
{

  //��������� ������
  $title = iconv("UTF-8", "windows-1251",  $_POST['ask_title']);
  $title = filter_var(mb_substr(trim($title), 0, 55), FILTER_SANITIZE_STRING);
  
  //������� �������� ������
  $desc = iconv("UTF-8", "windows-1251",  $_POST['ask_desc']);
  $desc = filter_var(mb_substr(trim($desc),0 ,55), FILTER_SANITIZE_STRING);

  //URL �����
  $url = isset($_POST['ask_url']) ? trim($_POST['ask_url']) : ''; 
  if (!filter_var($url, FILTER_VALIDATE_URL)) { echo '<span class="msgbox-error">�������� ����� �����</span>'; return; }
  
  //����� ��������� ������
  $timer = isset($_POST['ask_timer']) ? (int)$_POST['ask_timer'] : 20;
  $timer_arr = array('20' => 20, '30' => 30, '40' => 40, '50' => 50, '60' => 60);
  if (!isset($timer_arr[$timer])) { echo '<span class="msgbox-error">������ ������</span>'; return; }
  
  //����������� ������� �� ����
  $move = isset($_POST['ask_move']) ? (int)$_POST['ask_move'] : 0;
  if ($move > 1 || $move < 0) { echo '<span class="msgbox-error">������ ������</span>'; return; }
  
  //�������� ������
  $high = isset($_POST['ask_high']) ? (int)$_POST['ask_high'] : 0;
  if ($high > 1 || $high < 0) { echo '<span class="msgbox-error">������ ������</span>'; return; }
  
  //��������� ���������
  $speed = isset($_POST['ask_speed']) ? (int)$_POST['ask_speed'] : 0;
  if ($speed > 7 || $speed < 1) { echo '<span class="msgbox-error">������ ������</span>'; return; }
  
  //�� ��������
  $rating = isset($_POST['ask_rating']) ? (int)$_POST['ask_rating'] : 0;
  $rating_arr = array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5);
  if (!isset($rating_arr[$rating])) { echo '<span class="msgbox-error">������ ������</span>'; return; }
  
  //$kolvo = (int)$_POST['ask_kolvo'];
  
  //����������� �� �������
  $country1 = isset($_POST['ask_country1']) ? filter_var(mb_substr($_POST['ask_country1'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country2 = isset($_POST['ask_country2']) ? filter_var(mb_substr($_POST['ask_country2'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country3 = isset($_POST['ask_country3']) ? filter_var(mb_substr($_POST['ask_country3'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country4 = isset($_POST['ask_country4']) ? filter_var(mb_substr($_POST['ask_country4'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country5 = isset($_POST['ask_country5']) ? filter_var(mb_substr($_POST['ask_country5'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  
  $country = '';
  
  $crev = isset($_POST['ask_crev']) ? (int)$_POST['ask_crev'] : 0;
  
  if ($crev > 1 || $crev < 0) { echo '<span class="msgbox-error">������ ������</span>'; return; }
  
  if ($country1 != 'xx' || $country2 != 'xx' || $country3 != 'xx' || $country4 != 'xx' || $country5 != 'xx') 
  { 
    $country = $country1.'|'.$country2.'|'.$country3.'|'.$country4.'|'.$country5; 
  }
  
  //���� �� ��������� �������� ����
  if ($title == '' || $desc == '' || $url == '') { echo '<span class="msgbox-error">��������� �� ��� ����</span>'; return; }
  
  //������ ��������� ���������
  $price = SERF_PRICE; 
  
  if ($move == 1) {$price += SERF_PRICE_MOVE; }
  
  if ($high == 1) { $price += SERF_PRICE_HIGH; }
  
  if ($timer == 30) { $price += SERF_PRICE_TIMER; } 
  else if ($timer == 40) { $price += (SERF_PRICE_TIMER * 2); } 
  else if ($timer == 50) { $price += (SERF_PRICE_TIMER * 3); } 
  else if ($timer == 60) { $price += (SERF_PRICE_TIMER * 4); }
  
  if (($rating > 0)|($country1 != 'xx')|($country2 != 'xx')|($country3 != 'xx')|
        ($country4 != 'xx')|($country5 != 'xx')) {
        $price += SERF_PRICE_TARGET;
    }
   
   
  $price = number_format($price, 2, '.', '');
  
  if ($advedit) 
  {  
    if (!isset($_SESSION['admin']))
    {
      if ($result['title'] != $title || $result['desc'] != $desc || $result['url'] != $url)
      {
        $status = 0;      
      }
    }  
   
    $db->query("UPDATE db_serfing SET `title` = '".$title."', `desc` = '".$desc."', `url` = '".$url."', `timer` = '".$timer."', `move` = '".$move."', `high` = '".$high."', `speed` = '".$speed."', `country` = '".$country."', `rating` = '".$rating."', `crev` = '".$crev."', `price` = '".$price."', `status` = '".$status."' WHERE id = '".$advedit."'");
    
    if (isset($_SESSION['admin'])) 
    {
      header('Location: /account/serfing/moder'); 
    } 
    else
    {
      header('Location: /account/serfing/cabinet'); 
    }
    
    exit();
  }
  else
  { 
    if (isset($_SESSION['admin']))
    {
      $status = '3';
    }
    else
    {
      $status = '0';
    }
   
    $db->query("INSERT INTO db_serfing
        (
	  `user_name`,
	  `time_add`,	    
    `title`,
    `desc`,
    `url`,         
    `timer`,
    `move`,
	  `high`,
	  `speed`,	  
	  `country`,
    `rating`,
	  `crev`,
	  `price`,
    `status`
    
        )
        VALUES
        (
          '".$_SESSION['user']."',
	  '".TIME."',
	  '".$title."',
	  '".$desc."',
	  '".$url."', 
	  '".$timer."',
	  '".$move."', 
	  '".$high."',
	  '".$speed."',	  
	  '".$country."',
    '".$rating."', 
	  '".$crev."',
	  '".$price."',
    '".$status."' 
    
        )");
  
    //echo '<span class="msgbox-success">������ ���������</span>';
  
    header('Location: /account/serfing/cabinet'); exit();
  }  
} 

//end:

?>
<script>
 function SbmForm() {
    if (document.forms['surforder'].ask_title.value == '') {
        alert('�� �� ������� ��������� ������');
        document.forms['surforder'].ask_title.focus();
        return false;
    }
    if (document.forms['surforder'].ask_desc.value == '') {
        alert('�� �� ������� ������� �������� ������');
        document.forms['surforder'].ask_desc.focus();
        return false;
    }
    if ((document.forms['surforder'].ask_url.value == '')|(document.forms['surforder'].ask_url.value == 'http://')) {
        alert('�� �� ������� URL-����� ������');
        document.forms['surforder'].ask_url.focus();
        return false;
    }
    
    document.forms['surforder'].submit();
    return true;
}
 
 function PlanChange(frm)
{
   
 
    lprice = serf_price;
    if (frm.ask_move.value == 1) {
        lprice += serf_price_move;
    }
    if (frm.ask_high.value == 1) {
        lprice += serf_price_high;
    }
    if (frm.ask_timer.value == 30) {
        lprice += serf_price_timer;
    } else
    if (frm.ask_timer.value == 40) {
        lprice += (serf_price_timer * 2);
    } else
    if (frm.ask_timer.value == 50) {
        lprice += (serf_price_timer * 3);
    } else
    if (frm.ask_timer.value == 60) {
        lprice += (serf_price_timer * 4);
    }
    if ((frm.ask_rating.value > 0)|(frm.ask_country1.value != 'xx')|(frm.ask_country2.value != 'xx')|(frm.ask_country3.value != 'xx')|(frm.ask_country4.value != 'xx')|(frm.ask_country5.value != 'xx'))
    {    
        lprice += serf_price_target;
    }
    frm.linkprice.value = number_format(lprice, 2, '.', '');
    
    //money = lprice * $('input[name=ask_kolvo]').val();
    
    //frm.money.value = number_format(money, 2, '.', '');
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var i, j, kw, kd, km;
    if (isNaN(decimals = Math.abs(decimals))) {
        decimals = 2;
    }
    if (dec_point == undefined) {
        dec_point = ",";
    }
    if (thousands_sep == undefined) {
        thousands_sep = ".";
    }
    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
    if ((j = i.length) > 3) {
        j = j % 3;
    } else {
        j = 0;
    }
    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
    return km + kw + kd;
}
 
 function showhide(bid) {
    if (document.getElementById('cattitle'+bid).className == 'cattitle-open')
        document.getElementById('cattitle'+bid).className = 'cattitle-close'; else
        document.getElementById('cattitle'+bid).className = 'cattitle-open';
    $('#catblock'+bid).slideToggle('fast');
}


            var serf_price = <?php echo SERF_PRICE; ?>;
            var serf_price_timer = <?php echo SERF_PRICE_TIMER; ?>;
            var serf_price_move = <?php echo SERF_PRICE_MOVE; ?>;
            var serf_price_high = <?php echo SERF_PRICE_HIGH; ?>;
            var serf_price_target = <?php echo SERF_PRICE_TARGET; ?>;
            function ClearForm()
            {
                document.forms['surforder'].ask_timer.value = <?php echo $timer; ?>;
                document.forms['surforder'].ask_move.value = <?php echo $move; ?>;
                document.forms['surforder'].ask_high.value = <?php echo $high; ?>;
                document.forms['surforder'].ask_speed.value = <?php echo $speed; ?>;
                document.forms['surforder'].ask_rating.value = <?php echo $rating; ?>;   
                document.forms['surforder'].ask_country1.value = '<?php echo $country1; ?>';
                document.forms['surforder'].ask_country2.value = '<?php echo $country2; ?>';
                document.forms['surforder'].ask_country3.value = '<?php echo $country3; ?>';
                document.forms['surforder'].ask_country4.value = '<?php echo $country4; ?>';
                document.forms['surforder'].ask_country5.value = '<?php echo $country5; ?>';
                document.forms['surforder'].ask_crev.value = '<?php echo $crev; ?>';
                PlanChange(document.forms['surforder']);
            }
            
            $(document).ready(function() { ClearForm(); });
        
</script> 

<div class="s-bk-lf">
	<div class="acc-title9">�������� �������</div>
</div>

<div class="silver-bk">
    <p>������������� ��������� ���������� ��������� ������ �� �������:</p>
    <ul class="arrowred">
        <li>���������� ������ � ���������� �����/������</li>
        <li>����� � ���������� �� ������ �����, ������� �������� �����-���������</li>
        <li>����������� ����� � ��������</li>
        <li>���������� ����������� ��� ������ ����������� ����������</li>
        <li>���������� ����������� � ������������� �������</li>
        <li>����-���� � ����� ��������� ���� "�� ���� ����"</li>
        <li>���������� �������������� ����������� ����������</li>
        <li>����������� � �������, �������, ������������, ����������� ���������</li>
        <li>������������ � ����������� �������</li>
        <li>������� ��� ����� �������������, ����� ����������� ������ � ������� ������</li>
        <li>������� � ���������� �����, ����������, �����������</li>
        <li>�������, � ���� ���������� �������</li>
        <li>�������, ��������� "�� ��� �����", �.�. ������� ���������� ��������, ����������� pop-up � �.�.</li>
        <li>�������, ��������� �������� ������� ���-���������</li>
        <li>�����, ������� ������������ ����� �����������, ���������� ������� �������� ��� ������ ������� ��������</li>
        <li>�������, ���������� ���������������� ��</li>
    </ul>
    <p style="color: red; font-weight: bold;">� ������� �� ���������� ������ ��� �������� ��� �������������� � ���������� �������.</p>

 <div id="entermsg"><?php if (!empty($msg)) { echo $msg; } ?></div>

<form accept-charset="utf-8"  name="surforder" method="post" action="/account/serfing/add" >

    <span id="cattitle2" class="cattitle-new">����� �������� ��������� ��������</span>

<div id="catblock2">

    <input type="hidden" name="ask_editcode" value="<?php echo $advedit; ?>" />

    <table class='profile' style='margin-bottom: 0;'>
        <tbody>
            <tr>
                <td><b>��������� ������</b></td>
                <td class="value"><input class="val" type="text" name="ask_title" maxlength="55" value="<?php echo $title; ?>" /></td>
                <td class="service"></td>
            </tr>
            <tr>
                <td><b>������� �������� ������</b></td>
                <td class="value"><input class="val" type="text" name="ask_desc" maxlength="55" value="<?php echo $desc; ?>" /></td>
                <td class="service"></td>
            </tr>
            <tr>
                <td><b>URL �����</b> (������� http://)</td>
                <td class="value"><input class="val" type="text" name="ask_url" maxlength="300" value="<?php echo $url; ?>" /></td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>����� ��������� ������</td>
                <td class="value">
                    <select class="val" name="ask_timer" onChange="PlanChange(this.form); return false;">
                        <option value="20">20 ������</option>
                        <option value="30">30 ������&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER; ?> ���.)</option>
                        <option value="40">40 ������&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER*2; ?> ���.)</option>
                        <option value="50">50 ������&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER*3; ?> ���.)</option>
                        <option value="60">60 ������&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER*4; ?> ���.)</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>�������� ������</td>
                <td class="value">
                    <select class="val" name="ask_high" onChange="PlanChange(this.form); return false;">
                        <option value="0">���</option>
                        <option value="1">��&nbsp;&nbsp;(+ <?php echo SERF_PRICE_HIGH; ?> ���.)</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>����������� ������� �� ����</td>
                <td class="value">
                    <select class="val" name="ask_move" onChange="PlanChange(this.form); return false;">
                        <option value="0">���</option>
                        <option value="1">��&nbsp;&nbsp;(+ <?php echo SERF_PRICE_MOVE; ?> ���.)</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr class="hidden">
                <td>��������� ���������</td>
                <td class="value">
                    <select class="val" name="ask_speed">
                        <option value="1" selected>��� ������������ �������</option>
                        <option value="2">1/2 �������������</option>
                        <option value="3">1/3 �������������</option>
                        <option value="4">1/4 �������������</option>
                        <option value="5">����� ��������� �������</option>
                        <option value="6">����� ��������� �������</option>
                        <option value="7">��������� �������</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>��������� ������ ���������</td>
                <td class="price" colspan="2">
                <input type="text" name="linkprice" maxlength="5" value="" readonly="readonly" /> �������.
                </td>
            </tr>
        </tbody>
    </table>
</div>

    <span id="cattitle3" class="cattitle-open hidden" onclick="showhide(3);">����������� ����� ������� ���������, ��������� (+ <?php echo SERF_PRICE_TARGET; ?> ���.)</span>

<div id="catblock3" style="margin-bottom: 20px; display: none; ">
    <table class='profile' width='100%' border='0' cellpadding='0' cellspacing='0' style="margin-bottom: 0;">
        <tr>
            <td>�� ��������</td>
            <td class="value">
                <select class="val" name="ask_rating" onChange="PlanChange(this.form); return false;">
                    <option value="0" selected="selected">��� ������������</option>
                    <option value="1">�����</option>
                    <option value="2">������ 3 ������</option>
                    <option value="3">������ 2 ������</option>
                    <option value="4">������ 1 ������</option>
                    <option value="5">StreetRacer</option>
                </select>
            </td>
            <td class="service"></td>
        </tr>
        <tr>
            <td><b>����������� �� �������</b></td>
            <td class="value">
                <select class="val" name="ask_crev">
                    <option value="0" selected="selected">���������� ������ ��������� ���� �������</option>
                    <option value="1">���������� ����, ����� ��������� ���� �������</option>
                </select>
            </td>
            <td class="service"></td>
        </tr>
        <tr>
            <td width='44%'>����� �����</td>
            <td class="value">
                <select class="country" name="ask_country1" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">�� �������</option>
                    <option value="AU">���������</option><option value="AT">�������</option><option value="AZ">�����������</option><option value="AP">��������-������������� ������</option><option value="AX">��������� �������</option><option value="AL">�������</option><option value="DZ">�����</option><option value="VI">������������ ���������� �������</option><option value="AS">������������ �����</option><option value="AI">�������</option><option value="AO">������</option><option value="AD">�������</option><option value="AQ">����������</option><option value="AG">������� � �������</option><option value="AR">���������</option><option value="AM">�������</option><option value="AW">�����</option><option value="AF">����������</option><option value="BS">������</option><option value="BD">���������</option><option value="BB">��������</option><option value="BH">�������</option><option value="BY">��������</option><option value="BZ">�����</option><option value="BE">�������</option><option value="BJ">�����</option><option value="BM">�������</option><option value="BG">��������</option><option value="BO">�������</option><option value="BA">������ � �����������</option><option value="BW">��������</option><option value="BR">��������</option><option value="IO">���������� ���������� � ��������� ������</option><option value="VG">���������� ���������� �������</option><option value="BN">������</option><option value="BF">�������-����</option><option value="BI">�������</option><option value="BT">�����</option><option value="VU">�������</option><option value="VA">�������</option><option value="GB">��������������</option><option value="HU">�������</option><option value="VE">���������</option><option value="UM">������� ����� ������� (���)</option><option value="TL">��������� �����</option><option value="VN">�������</option><option value="GA">�����</option><option value="HT">�����</option><option value="GY">������</option><option value="GM">������</option><option value="GH">����</option><option value="GP">���������</option><option value="GT">���������</option><option value="GN">������</option><option value="GW">������-�����</option><option value="DE">��������</option><option value="GG">������</option><option value="GI">���������</option><option value="HN">��������</option><option value="HK">�������</option><option value="GD">�������</option><option value="GL">����������</option><option value="GR">������</option><option value="GE">������</option><option value="GU">����</option><option value="DK">�����</option><option value="CD">��������������� ���������� �����</option><option value="JE">������</option><option value="DJ">�������</option><option value="DM">��������</option><option value="DO">������������� ����������</option><option value="EU">����������</option><option value="EG">������</option><option value="ZM">������</option><option value="ZW">��������</option><option value="IL">�������</option><option value="IN">�����</option><option value="ID">���������</option><option value="JO">��������</option><option value="IQ">����</option><option value="IR">����</option><option value="IE">��������</option><option value="IS">��������</option><option value="ES">�������</option><option value="IT">������</option><option value="YE">�����</option><option value="CV">����-�����</option><option value="KZ">���������</option><option value="KY">��������� �������</option><option value="KH">��������</option><option value="CM">�������</option><option value="CA">������</option><option value="QA">�����</option><option value="KE">�����</option><option value="CY">����</option><option value="KI">��������</option><option value="CN">�����</option><option value="CO">��������</option><option value="KM">������</option><option value="CG">�����</option><option value="CR">�����-����</option><option value="CI">���-������</option><option value="CU">����</option><option value="KW">������</option><option value="KG">����������</option><option value="LA">����</option><option value="LV">������</option><option value="LS">������</option><option value="LR">�������</option><option value="LB">�����</option><option value="LY">�����</option><option value="LT">�����</option><option value="LI">�����������</option><option value="LU">����������</option><option value="MU">��������</option><option value="MR">����������</option><option value="MG">����������</option><option value="YT">�������</option><option value="MO">�����</option><option value="MK">���������</option><option value="MW">������</option><option value="MY">��������</option><option value="ML">����</option><option value="MV">��������</option><option value="MT">������</option><option value="MA">�������</option><option value="MQ">���������</option><option value="MH">���������� �������</option><option value="MX">�������</option><option value="FM">����������</option><option value="MZ">��������</option><option value="MD">��������</option><option value="MC">������</option><option value="MN">��������</option><option value="MS">����������</option><option value="MM">������</option><option value="NA">�������</option><option value="NR">�����</option><option value="NP">�����</option><option value="NE">�����</option><option value="NG">�������</option><option value="AN">������������� ���������� �������</option><option value="NL">����������</option><option value="NI">���������</option><option value="NU">����</option><option value="NZ">����� ��������</option><option value="NC">����� ���������</option><option value="NO">��������</option><option value="AE">����������� �������� �������</option><option value="OM">����</option><option value="AC">������ ����������</option><option value="IM">������ ���</option><option value="NF">������ �������</option><option value="CX">������ ���������</option><option value="SH">������ ������ �����</option><option value="HM">������ ���� � ������� ���������</option><option value="CK">������� ����</option><option value="WF">������� ������ � ������</option><option value="PK">��������</option><option value="PW">�����</option><option value="PS">���������</option><option value="PA">������</option><option value="PG">�����-����� ������</option><option value="PY">��������</option><option value="PE">����</option><option value="PL">������</option><option value="PT">����������</option><option value="PR">������-����</option><option value="RE">�������</option><option value="RU">������</option><option value="RW">������</option><option value="RO">�������</option><option value="SV">���������</option><option value="WS">�����</option><option value="SM">���-������</option><option value="ST">���-���� � ��������</option><option value="SA">���������� ������</option><option value="SZ">���������</option><option value="KP">�������� �����</option><option value="MP">�������� ���������� �������</option><option value="SC">�������</option><option value="MF">���-������</option><option value="PM">���-���� � �������</option><option value="SN">�������</option><option value="VC">����-������� � ���������</option><option value="KN">����-����� � �����</option><option value="LC">����-�����</option><option value="RS">������</option><option value="SG">��������</option><option value="SY">�����</option><option value="SK">��������</option><option value="SI">��������</option><option value="US">���������� ����� �������</option><option value="SB">���������� �������</option><option value="SO">������</option><option value="SD">�����</option><option value="SR">�������</option><option value="SL">������-�����</option><option value="TJ">�����������</option><option value="TH">�������</option><option value="TW">�������</option><option value="TZ">��������</option><option value="TC">Ҹ��� � ������</option><option value="TG">����</option><option value="TK">�������</option><option value="TO">�����</option><option value="TT">�������� � ������</option><option value="TV">������</option><option value="TN">�����</option><option value="TM">���������</option><option value="TR">������</option><option value="UG">������</option><option value="UZ">����������</option><option value="UA">�������</option><option value="UY">�������</option><option value="FO">��������� �������</option><option value="FJ">�����</option><option value="PH">���������</option><option value="FI">���������</option><option value="FK">������������ �������</option><option value="FR">�������</option><option value="GF">����������� ������</option><option value="PF">����������� ���������</option><option value="HR">��������</option><option value="CF">��������������������� ����������</option><option value="TD">���</option><option value="ME">����������</option><option value="CZ">�����</option><option value="CL">����</option><option value="CH">���������</option><option value="SE">������</option><option value="LK">���-�����</option><option value="EC">�������</option><option value="GQ">�������������� ������</option><option value="ER">�������</option><option value="EE">�������</option><option value="ET">�������</option><option value="ZA">����� ������</option><option value="KR">����� �����</option><option value="JM">������</option><option value="JP">������</option><option value="XX">����������</option><option value="00">����������</option><option value="">����������</option>
                </select>
                <select class="country" name="ask_country2" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">�� �������</option>
                    <option value="AU">���������</option><option value="AT">�������</option><option value="AZ">�����������</option><option value="AP">��������-������������� ������</option><option value="AX">��������� �������</option><option value="AL">�������</option><option value="DZ">�����</option><option value="VI">������������ ���������� �������</option><option value="AS">������������ �����</option><option value="AI">�������</option><option value="AO">������</option><option value="AD">�������</option><option value="AQ">����������</option><option value="AG">������� � �������</option><option value="AR">���������</option><option value="AM">�������</option><option value="AW">�����</option><option value="AF">����������</option><option value="BS">������</option><option value="BD">���������</option><option value="BB">��������</option><option value="BH">�������</option><option value="BY">��������</option><option value="BZ">�����</option><option value="BE">�������</option><option value="BJ">�����</option><option value="BM">�������</option><option value="BG">��������</option><option value="BO">�������</option><option value="BA">������ � �����������</option><option value="BW">��������</option><option value="BR">��������</option><option value="IO">���������� ���������� � ��������� ������</option><option value="VG">���������� ���������� �������</option><option value="BN">������</option><option value="BF">�������-����</option><option value="BI">�������</option><option value="BT">�����</option><option value="VU">�������</option><option value="VA">�������</option><option value="GB">��������������</option><option value="HU">�������</option><option value="VE">���������</option><option value="UM">������� ����� ������� (���)</option><option value="TL">��������� �����</option><option value="VN">�������</option><option value="GA">�����</option><option value="HT">�����</option><option value="GY">������</option><option value="GM">������</option><option value="GH">����</option><option value="GP">���������</option><option value="GT">���������</option><option value="GN">������</option><option value="GW">������-�����</option><option value="DE">��������</option><option value="GG">������</option><option value="GI">���������</option><option value="HN">��������</option><option value="HK">�������</option><option value="GD">�������</option><option value="GL">����������</option><option value="GR">������</option><option value="GE">������</option><option value="GU">����</option><option value="DK">�����</option><option value="CD">��������������� ���������� �����</option><option value="JE">������</option><option value="DJ">�������</option><option value="DM">��������</option><option value="DO">������������� ����������</option><option value="EU">����������</option><option value="EG">������</option><option value="ZM">������</option><option value="ZW">��������</option><option value="IL">�������</option><option value="IN">�����</option><option value="ID">���������</option><option value="JO">��������</option><option value="IQ">����</option><option value="IR">����</option><option value="IE">��������</option><option value="IS">��������</option><option value="ES">�������</option><option value="IT">������</option><option value="YE">�����</option><option value="CV">����-�����</option><option value="KZ">���������</option><option value="KY">��������� �������</option><option value="KH">��������</option><option value="CM">�������</option><option value="CA">������</option><option value="QA">�����</option><option value="KE">�����</option><option value="CY">����</option><option value="KI">��������</option><option value="CN">�����</option><option value="CO">��������</option><option value="KM">������</option><option value="CG">�����</option><option value="CR">�����-����</option><option value="CI">���-������</option><option value="CU">����</option><option value="KW">������</option><option value="KG">����������</option><option value="LA">����</option><option value="LV">������</option><option value="LS">������</option><option value="LR">�������</option><option value="LB">�����</option><option value="LY">�����</option><option value="LT">�����</option><option value="LI">�����������</option><option value="LU">����������</option><option value="MU">��������</option><option value="MR">����������</option><option value="MG">����������</option><option value="YT">�������</option><option value="MO">�����</option><option value="MK">���������</option><option value="MW">������</option><option value="MY">��������</option><option value="ML">����</option><option value="MV">��������</option><option value="MT">������</option><option value="MA">�������</option><option value="MQ">���������</option><option value="MH">���������� �������</option><option value="MX">�������</option><option value="FM">����������</option><option value="MZ">��������</option><option value="MD">��������</option><option value="MC">������</option><option value="MN">��������</option><option value="MS">����������</option><option value="MM">������</option><option value="NA">�������</option><option value="NR">�����</option><option value="NP">�����</option><option value="NE">�����</option><option value="NG">�������</option><option value="AN">������������� ���������� �������</option><option value="NL">����������</option><option value="NI">���������</option><option value="NU">����</option><option value="NZ">����� ��������</option><option value="NC">����� ���������</option><option value="NO">��������</option><option value="AE">����������� �������� �������</option><option value="OM">����</option><option value="AC">������ ����������</option><option value="IM">������ ���</option><option value="NF">������ �������</option><option value="CX">������ ���������</option><option value="SH">������ ������ �����</option><option value="HM">������ ���� � ������� ���������</option><option value="CK">������� ����</option><option value="WF">������� ������ � ������</option><option value="PK">��������</option><option value="PW">�����</option><option value="PS">���������</option><option value="PA">������</option><option value="PG">�����-����� ������</option><option value="PY">��������</option><option value="PE">����</option><option value="PL">������</option><option value="PT">����������</option><option value="PR">������-����</option><option value="RE">�������</option><option value="RU">������</option><option value="RW">������</option><option value="RO">�������</option><option value="SV">���������</option><option value="WS">�����</option><option value="SM">���-������</option><option value="ST">���-���� � ��������</option><option value="SA">���������� ������</option><option value="SZ">���������</option><option value="KP">�������� �����</option><option value="MP">�������� ���������� �������</option><option value="SC">�������</option><option value="MF">���-������</option><option value="PM">���-���� � �������</option><option value="SN">�������</option><option value="VC">����-������� � ���������</option><option value="KN">����-����� � �����</option><option value="LC">����-�����</option><option value="RS">������</option><option value="SG">��������</option><option value="SY">�����</option><option value="SK">��������</option><option value="SI">��������</option><option value="US">���������� ����� �������</option><option value="SB">���������� �������</option><option value="SO">������</option><option value="SD">�����</option><option value="SR">�������</option><option value="SL">������-�����</option><option value="TJ">�����������</option><option value="TH">�������</option><option value="TW">�������</option><option value="TZ">��������</option><option value="TC">Ҹ��� � ������</option><option value="TG">����</option><option value="TK">�������</option><option value="TO">�����</option><option value="TT">�������� � ������</option><option value="TV">������</option><option value="TN">�����</option><option value="TM">���������</option><option value="TR">������</option><option value="UG">������</option><option value="UZ">����������</option><option value="UA">�������</option><option value="UY">�������</option><option value="FO">��������� �������</option><option value="FJ">�����</option><option value="PH">���������</option><option value="FI">���������</option><option value="FK">������������ �������</option><option value="FR">�������</option><option value="GF">����������� ������</option><option value="PF">����������� ���������</option><option value="HR">��������</option><option value="CF">��������������������� ����������</option><option value="TD">���</option><option value="ME">����������</option><option value="CZ">�����</option><option value="CL">����</option><option value="CH">���������</option><option value="SE">������</option><option value="LK">���-�����</option><option value="EC">�������</option><option value="GQ">�������������� ������</option><option value="ER">�������</option><option value="EE">�������</option><option value="ET">�������</option><option value="ZA">����� ������</option><option value="KR">����� �����</option><option value="JM">������</option><option value="JP">������</option><option value="XX">����������</option><option value="00">����������</option><option value="">����������</option>
                </select>
                <select class="country" name="ask_country3" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">�� �������</option>
                    <option value="AU">���������</option><option value="AT">�������</option><option value="AZ">�����������</option><option value="AP">��������-������������� ������</option><option value="AX">��������� �������</option><option value="AL">�������</option><option value="DZ">�����</option><option value="VI">������������ ���������� �������</option><option value="AS">������������ �����</option><option value="AI">�������</option><option value="AO">������</option><option value="AD">�������</option><option value="AQ">����������</option><option value="AG">������� � �������</option><option value="AR">���������</option><option value="AM">�������</option><option value="AW">�����</option><option value="AF">����������</option><option value="BS">������</option><option value="BD">���������</option><option value="BB">��������</option><option value="BH">�������</option><option value="BY">��������</option><option value="BZ">�����</option><option value="BE">�������</option><option value="BJ">�����</option><option value="BM">�������</option><option value="BG">��������</option><option value="BO">�������</option><option value="BA">������ � �����������</option><option value="BW">��������</option><option value="BR">��������</option><option value="IO">���������� ���������� � ��������� ������</option><option value="VG">���������� ���������� �������</option><option value="BN">������</option><option value="BF">�������-����</option><option value="BI">�������</option><option value="BT">�����</option><option value="VU">�������</option><option value="VA">�������</option><option value="GB">��������������</option><option value="HU">�������</option><option value="VE">���������</option><option value="UM">������� ����� ������� (���)</option><option value="TL">��������� �����</option><option value="VN">�������</option><option value="GA">�����</option><option value="HT">�����</option><option value="GY">������</option><option value="GM">������</option><option value="GH">����</option><option value="GP">���������</option><option value="GT">���������</option><option value="GN">������</option><option value="GW">������-�����</option><option value="DE">��������</option><option value="GG">������</option><option value="GI">���������</option><option value="HN">��������</option><option value="HK">�������</option><option value="GD">�������</option><option value="GL">����������</option><option value="GR">������</option><option value="GE">������</option><option value="GU">����</option><option value="DK">�����</option><option value="CD">��������������� ���������� �����</option><option value="JE">������</option><option value="DJ">�������</option><option value="DM">��������</option><option value="DO">������������� ����������</option><option value="EU">����������</option><option value="EG">������</option><option value="ZM">������</option><option value="ZW">��������</option><option value="IL">�������</option><option value="IN">�����</option><option value="ID">���������</option><option value="JO">��������</option><option value="IQ">����</option><option value="IR">����</option><option value="IE">��������</option><option value="IS">��������</option><option value="ES">�������</option><option value="IT">������</option><option value="YE">�����</option><option value="CV">����-�����</option><option value="KZ">���������</option><option value="KY">��������� �������</option><option value="KH">��������</option><option value="CM">�������</option><option value="CA">������</option><option value="QA">�����</option><option value="KE">�����</option><option value="CY">����</option><option value="KI">��������</option><option value="CN">�����</option><option value="CO">��������</option><option value="KM">������</option><option value="CG">�����</option><option value="CR">�����-����</option><option value="CI">���-������</option><option value="CU">����</option><option value="KW">������</option><option value="KG">����������</option><option value="LA">����</option><option value="LV">������</option><option value="LS">������</option><option value="LR">�������</option><option value="LB">�����</option><option value="LY">�����</option><option value="LT">�����</option><option value="LI">�����������</option><option value="LU">����������</option><option value="MU">��������</option><option value="MR">����������</option><option value="MG">����������</option><option value="YT">�������</option><option value="MO">�����</option><option value="MK">���������</option><option value="MW">������</option><option value="MY">��������</option><option value="ML">����</option><option value="MV">��������</option><option value="MT">������</option><option value="MA">�������</option><option value="MQ">���������</option><option value="MH">���������� �������</option><option value="MX">�������</option><option value="FM">����������</option><option value="MZ">��������</option><option value="MD">��������</option><option value="MC">������</option><option value="MN">��������</option><option value="MS">����������</option><option value="MM">������</option><option value="NA">�������</option><option value="NR">�����</option><option value="NP">�����</option><option value="NE">�����</option><option value="NG">�������</option><option value="AN">������������� ���������� �������</option><option value="NL">����������</option><option value="NI">���������</option><option value="NU">����</option><option value="NZ">����� ��������</option><option value="NC">����� ���������</option><option value="NO">��������</option><option value="AE">����������� �������� �������</option><option value="OM">����</option><option value="AC">������ ����������</option><option value="IM">������ ���</option><option value="NF">������ �������</option><option value="CX">������ ���������</option><option value="SH">������ ������ �����</option><option value="HM">������ ���� � ������� ���������</option><option value="CK">������� ����</option><option value="WF">������� ������ � ������</option><option value="PK">��������</option><option value="PW">�����</option><option value="PS">���������</option><option value="PA">������</option><option value="PG">�����-����� ������</option><option value="PY">��������</option><option value="PE">����</option><option value="PL">������</option><option value="PT">����������</option><option value="PR">������-����</option><option value="RE">�������</option><option value="RU">������</option><option value="RW">������</option><option value="RO">�������</option><option value="SV">���������</option><option value="WS">�����</option><option value="SM">���-������</option><option value="ST">���-���� � ��������</option><option value="SA">���������� ������</option><option value="SZ">���������</option><option value="KP">�������� �����</option><option value="MP">�������� ���������� �������</option><option value="SC">�������</option><option value="MF">���-������</option><option value="PM">���-���� � �������</option><option value="SN">�������</option><option value="VC">����-������� � ���������</option><option value="KN">����-����� � �����</option><option value="LC">����-�����</option><option value="RS">������</option><option value="SG">��������</option><option value="SY">�����</option><option value="SK">��������</option><option value="SI">��������</option><option value="US">���������� ����� �������</option><option value="SB">���������� �������</option><option value="SO">������</option><option value="SD">�����</option><option value="SR">�������</option><option value="SL">������-�����</option><option value="TJ">�����������</option><option value="TH">�������</option><option value="TW">�������</option><option value="TZ">��������</option><option value="TC">Ҹ��� � ������</option><option value="TG">����</option><option value="TK">�������</option><option value="TO">�����</option><option value="TT">�������� � ������</option><option value="TV">������</option><option value="TN">�����</option><option value="TM">���������</option><option value="TR">������</option><option value="UG">������</option><option value="UZ">����������</option><option value="UA">�������</option><option value="UY">�������</option><option value="FO">��������� �������</option><option value="FJ">�����</option><option value="PH">���������</option><option value="FI">���������</option><option value="FK">������������ �������</option><option value="FR">�������</option><option value="GF">����������� ������</option><option value="PF">����������� ���������</option><option value="HR">��������</option><option value="CF">��������������������� ����������</option><option value="TD">���</option><option value="ME">����������</option><option value="CZ">�����</option><option value="CL">����</option><option value="CH">���������</option><option value="SE">������</option><option value="LK">���-�����</option><option value="EC">�������</option><option value="GQ">�������������� ������</option><option value="ER">�������</option><option value="EE">�������</option><option value="ET">�������</option><option value="ZA">����� ������</option><option value="KR">����� �����</option><option value="JM">������</option><option value="JP">������</option><option value="XX">����������</option><option value="00">����������</option><option value="">����������</option>
                </select>
                <select class="country" name="ask_country4" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">�� �������</option>
                    <option value="AU">���������</option><option value="AT">�������</option><option value="AZ">�����������</option><option value="AP">��������-������������� ������</option><option value="AX">��������� �������</option><option value="AL">�������</option><option value="DZ">�����</option><option value="VI">������������ ���������� �������</option><option value="AS">������������ �����</option><option value="AI">�������</option><option value="AO">������</option><option value="AD">�������</option><option value="AQ">����������</option><option value="AG">������� � �������</option><option value="AR">���������</option><option value="AM">�������</option><option value="AW">�����</option><option value="AF">����������</option><option value="BS">������</option><option value="BD">���������</option><option value="BB">��������</option><option value="BH">�������</option><option value="BY">��������</option><option value="BZ">�����</option><option value="BE">�������</option><option value="BJ">�����</option><option value="BM">�������</option><option value="BG">��������</option><option value="BO">�������</option><option value="BA">������ � �����������</option><option value="BW">��������</option><option value="BR">��������</option><option value="IO">���������� ���������� � ��������� ������</option><option value="VG">���������� ���������� �������</option><option value="BN">������</option><option value="BF">�������-����</option><option value="BI">�������</option><option value="BT">�����</option><option value="VU">�������</option><option value="VA">�������</option><option value="GB">��������������</option><option value="HU">�������</option><option value="VE">���������</option><option value="UM">������� ����� ������� (���)</option><option value="TL">��������� �����</option><option value="VN">�������</option><option value="GA">�����</option><option value="HT">�����</option><option value="GY">������</option><option value="GM">������</option><option value="GH">����</option><option value="GP">���������</option><option value="GT">���������</option><option value="GN">������</option><option value="GW">������-�����</option><option value="DE">��������</option><option value="GG">������</option><option value="GI">���������</option><option value="HN">��������</option><option value="HK">�������</option><option value="GD">�������</option><option value="GL">����������</option><option value="GR">������</option><option value="GE">������</option><option value="GU">����</option><option value="DK">�����</option><option value="CD">��������������� ���������� �����</option><option value="JE">������</option><option value="DJ">�������</option><option value="DM">��������</option><option value="DO">������������� ����������</option><option value="EU">����������</option><option value="EG">������</option><option value="ZM">������</option><option value="ZW">��������</option><option value="IL">�������</option><option value="IN">�����</option><option value="ID">���������</option><option value="JO">��������</option><option value="IQ">����</option><option value="IR">����</option><option value="IE">��������</option><option value="IS">��������</option><option value="ES">�������</option><option value="IT">������</option><option value="YE">�����</option><option value="CV">����-�����</option><option value="KZ">���������</option><option value="KY">��������� �������</option><option value="KH">��������</option><option value="CM">�������</option><option value="CA">������</option><option value="QA">�����</option><option value="KE">�����</option><option value="CY">����</option><option value="KI">��������</option><option value="CN">�����</option><option value="CO">��������</option><option value="KM">������</option><option value="CG">�����</option><option value="CR">�����-����</option><option value="CI">���-������</option><option value="CU">����</option><option value="KW">������</option><option value="KG">����������</option><option value="LA">����</option><option value="LV">������</option><option value="LS">������</option><option value="LR">�������</option><option value="LB">�����</option><option value="LY">�����</option><option value="LT">�����</option><option value="LI">�����������</option><option value="LU">����������</option><option value="MU">��������</option><option value="MR">����������</option><option value="MG">����������</option><option value="YT">�������</option><option value="MO">�����</option><option value="MK">���������</option><option value="MW">������</option><option value="MY">��������</option><option value="ML">����</option><option value="MV">��������</option><option value="MT">������</option><option value="MA">�������</option><option value="MQ">���������</option><option value="MH">���������� �������</option><option value="MX">�������</option><option value="FM">����������</option><option value="MZ">��������</option><option value="MD">��������</option><option value="MC">������</option><option value="MN">��������</option><option value="MS">����������</option><option value="MM">������</option><option value="NA">�������</option><option value="NR">�����</option><option value="NP">�����</option><option value="NE">�����</option><option value="NG">�������</option><option value="AN">������������� ���������� �������</option><option value="NL">����������</option><option value="NI">���������</option><option value="NU">����</option><option value="NZ">����� ��������</option><option value="NC">����� ���������</option><option value="NO">��������</option><option value="AE">����������� �������� �������</option><option value="OM">����</option><option value="AC">������ ����������</option><option value="IM">������ ���</option><option value="NF">������ �������</option><option value="CX">������ ���������</option><option value="SH">������ ������ �����</option><option value="HM">������ ���� � ������� ���������</option><option value="CK">������� ����</option><option value="WF">������� ������ � ������</option><option value="PK">��������</option><option value="PW">�����</option><option value="PS">���������</option><option value="PA">������</option><option value="PG">�����-����� ������</option><option value="PY">��������</option><option value="PE">����</option><option value="PL">������</option><option value="PT">����������</option><option value="PR">������-����</option><option value="RE">�������</option><option value="RU">������</option><option value="RW">������</option><option value="RO">�������</option><option value="SV">���������</option><option value="WS">�����</option><option value="SM">���-������</option><option value="ST">���-���� � ��������</option><option value="SA">���������� ������</option><option value="SZ">���������</option><option value="KP">�������� �����</option><option value="MP">�������� ���������� �������</option><option value="SC">�������</option><option value="MF">���-������</option><option value="PM">���-���� � �������</option><option value="SN">�������</option><option value="VC">����-������� � ���������</option><option value="KN">����-����� � �����</option><option value="LC">����-�����</option><option value="RS">������</option><option value="SG">��������</option><option value="SY">�����</option><option value="SK">��������</option><option value="SI">��������</option><option value="US">���������� ����� �������</option><option value="SB">���������� �������</option><option value="SO">������</option><option value="SD">�����</option><option value="SR">�������</option><option value="SL">������-�����</option><option value="TJ">�����������</option><option value="TH">�������</option><option value="TW">�������</option><option value="TZ">��������</option><option value="TC">Ҹ��� � ������</option><option value="TG">����</option><option value="TK">�������</option><option value="TO">�����</option><option value="TT">�������� � ������</option><option value="TV">������</option><option value="TN">�����</option><option value="TM">���������</option><option value="TR">������</option><option value="UG">������</option><option value="UZ">����������</option><option value="UA">�������</option><option value="UY">�������</option><option value="FO">��������� �������</option><option value="FJ">�����</option><option value="PH">���������</option><option value="FI">���������</option><option value="FK">������������ �������</option><option value="FR">�������</option><option value="GF">����������� ������</option><option value="PF">����������� ���������</option><option value="HR">��������</option><option value="CF">��������������������� ����������</option><option value="TD">���</option><option value="ME">����������</option><option value="CZ">�����</option><option value="CL">����</option><option value="CH">���������</option><option value="SE">������</option><option value="LK">���-�����</option><option value="EC">�������</option><option value="GQ">�������������� ������</option><option value="ER">�������</option><option value="EE">�������</option><option value="ET">�������</option><option value="ZA">����� ������</option><option value="KR">����� �����</option><option value="JM">������</option><option value="JP">������</option><option value="XX">����������</option><option value="00">����������</option><option value="">����������</option>
                </select>
                <select class="country" name="ask_country5" onChange="PlanChange(this.form); return false;">
                <option value="xx" selected="selected">�� �������</option>
                <option value="AU">���������</option><option value="AT">�������</option><option value="AZ">�����������</option><option value="AP">��������-������������� ������</option><option value="AX">��������� �������</option><option value="AL">�������</option><option value="DZ">�����</option><option value="VI">������������ ���������� �������</option><option value="AS">������������ �����</option><option value="AI">�������</option><option value="AO">������</option><option value="AD">�������</option><option value="AQ">����������</option><option value="AG">������� � �������</option><option value="AR">���������</option><option value="AM">�������</option><option value="AW">�����</option><option value="AF">����������</option><option value="BS">������</option><option value="BD">���������</option><option value="BB">��������</option><option value="BH">�������</option><option value="BY">��������</option><option value="BZ">�����</option><option value="BE">�������</option><option value="BJ">�����</option><option value="BM">�������</option><option value="BG">��������</option><option value="BO">�������</option><option value="BA">������ � �����������</option><option value="BW">��������</option><option value="BR">��������</option><option value="IO">���������� ���������� � ��������� ������</option><option value="VG">���������� ���������� �������</option><option value="BN">������</option><option value="BF">�������-����</option><option value="BI">�������</option><option value="BT">�����</option><option value="VU">�������</option><option value="VA">�������</option><option value="GB">��������������</option><option value="HU">�������</option><option value="VE">���������</option><option value="UM">������� ����� ������� (���)</option><option value="TL">��������� �����</option><option value="VN">�������</option><option value="GA">�����</option><option value="HT">�����</option><option value="GY">������</option><option value="GM">������</option><option value="GH">����</option><option value="GP">���������</option><option value="GT">���������</option><option value="GN">������</option><option value="GW">������-�����</option><option value="DE">��������</option><option value="GG">������</option><option value="GI">���������</option><option value="HN">��������</option><option value="HK">�������</option><option value="GD">�������</option><option value="GL">����������</option><option value="GR">������</option><option value="GE">������</option><option value="GU">����</option><option value="DK">�����</option><option value="CD">��������������� ���������� �����</option><option value="JE">������</option><option value="DJ">�������</option><option value="DM">��������</option><option value="DO">������������� ����������</option><option value="EU">����������</option><option value="EG">������</option><option value="ZM">������</option><option value="ZW">��������</option><option value="IL">�������</option><option value="IN">�����</option><option value="ID">���������</option><option value="JO">��������</option><option value="IQ">����</option><option value="IR">����</option><option value="IE">��������</option><option value="IS">��������</option><option value="ES">�������</option><option value="IT">������</option><option value="YE">�����</option><option value="CV">����-�����</option><option value="KZ">���������</option><option value="KY">��������� �������</option><option value="KH">��������</option><option value="CM">�������</option><option value="CA">������</option><option value="QA">�����</option><option value="KE">�����</option><option value="CY">����</option><option value="KI">��������</option><option value="CN">�����</option><option value="CO">��������</option><option value="KM">������</option><option value="CG">�����</option><option value="CR">�����-����</option><option value="CI">���-������</option><option value="CU">����</option><option value="KW">������</option><option value="KG">����������</option><option value="LA">����</option><option value="LV">������</option><option value="LS">������</option><option value="LR">�������</option><option value="LB">�����</option><option value="LY">�����</option><option value="LT">�����</option><option value="LI">�����������</option><option value="LU">����������</option><option value="MU">��������</option><option value="MR">����������</option><option value="MG">����������</option><option value="YT">�������</option><option value="MO">�����</option><option value="MK">���������</option><option value="MW">������</option><option value="MY">��������</option><option value="ML">����</option><option value="MV">��������</option><option value="MT">������</option><option value="MA">�������</option><option value="MQ">���������</option><option value="MH">���������� �������</option><option value="MX">�������</option><option value="FM">����������</option><option value="MZ">��������</option><option value="MD">��������</option><option value="MC">������</option><option value="MN">��������</option><option value="MS">����������</option><option value="MM">������</option><option value="NA">�������</option><option value="NR">�����</option><option value="NP">�����</option><option value="NE">�����</option><option value="NG">�������</option><option value="AN">������������� ���������� �������</option><option value="NL">����������</option><option value="NI">���������</option><option value="NU">����</option><option value="NZ">����� ��������</option><option value="NC">����� ���������</option><option value="NO">��������</option><option value="AE">����������� �������� �������</option><option value="OM">����</option><option value="AC">������ ����������</option><option value="IM">������ ���</option><option value="NF">������ �������</option><option value="CX">������ ���������</option><option value="SH">������ ������ �����</option><option value="HM">������ ���� � ������� ���������</option><option value="CK">������� ����</option><option value="WF">������� ������ � ������</option><option value="PK">��������</option><option value="PW">�����</option><option value="PS">���������</option><option value="PA">������</option><option value="PG">�����-����� ������</option><option value="PY">��������</option><option value="PE">����</option><option value="PL">������</option><option value="PT">����������</option><option value="PR">������-����</option><option value="RE">�������</option><option value="RU">������</option><option value="RW">������</option><option value="RO">�������</option><option value="SV">���������</option><option value="WS">�����</option><option value="SM">���-������</option><option value="ST">���-���� � ��������</option><option value="SA">���������� ������</option><option value="SZ">���������</option><option value="KP">�������� �����</option><option value="MP">�������� ���������� �������</option><option value="SC">�������</option><option value="MF">���-������</option><option value="PM">���-���� � �������</option><option value="SN">�������</option><option value="VC">����-������� � ���������</option><option value="KN">����-����� � �����</option><option value="LC">����-�����</option><option value="RS">������</option><option value="SG">��������</option><option value="SY">�����</option><option value="SK">��������</option><option value="SI">��������</option><option value="US">���������� ����� �������</option><option value="SB">���������� �������</option><option value="SO">������</option><option value="SD">�����</option><option value="SR">�������</option><option value="SL">������-�����</option><option value="TJ">�����������</option><option value="TH">�������</option><option value="TW">�������</option><option value="TZ">��������</option><option value="TC">Ҹ��� � ������</option><option value="TG">����</option><option value="TK">�������</option><option value="TO">�����</option><option value="TT">�������� � ������</option><option value="TV">������</option><option value="TN">�����</option><option value="TM">���������</option><option value="TR">������</option><option value="UG">������</option><option value="UZ">����������</option><option value="UA">�������</option><option value="UY">�������</option><option value="FO">��������� �������</option><option value="FJ">�����</option><option value="PH">���������</option><option value="FI">���������</option><option value="FK">������������ �������</option><option value="FR">�������</option><option value="GF">����������� ������</option><option value="PF">����������� ���������</option><option value="HR">��������</option><option value="CF">��������������������� ����������</option><option value="TD">���</option><option value="ME">����������</option><option value="CZ">�����</option><option value="CL">����</option><option value="CH">���������</option><option value="SE">������</option><option value="LK">���-�����</option><option value="EC">�������</option><option value="GQ">�������������� ������</option><option value="ER">�������</option><option value="EE">�������</option><option value="ET">�������</option><option value="ZA">����� ������</option><option value="KR">����� �����</option><option value="JM">������</option><option value="JP">������</option><option value="XX">����������</option><option value="00">����������</option><option value="">����������</option>
                </select>
            </td>
            <td class="service"></td>
        </tr>
    </table>
</div>
<?php
if ($advedit)
{
?>
<center>
    <span class="button-green" title="������� ���������" onclick="SbmForm();">���������</span>
</center>
<?php
}
else
{
?>
<center>
    <span class="button-green" title="���������� �������" onclick="SbmForm();">��������</span>
</center>
<?php
}
?>

</form>
 
</div>

</div>
 	