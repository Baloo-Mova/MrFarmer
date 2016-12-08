<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*
 * Серфинг для фермы
 * Версия: 1.00
 * SKYPE: sereega393
 * Использование без оплаты ЗАПРЕЩЕНО!!!
*/
define('TIME', time());

define('SERF_PRICE', 10); //минимальная стоимость просмотра
define('SERF_PRICE_TIMER', 0.2); //стоимость таймера
define('SERF_PRICE_MOVE', 0.8); //стоимость последующего перехода на сайт
define('SERF_PRICE_HIGH', 0.5); //стоимость выделения ссылки
define('SERF_PRICE_TARGET', 1.2); //стоимость таргетинга


header("Content-Type: text/html; charset=windows-1251");
$msg = '';

$db->Query("SELECT * FROM db_users_b WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchArray();
?>




<div class="text_right">

<link rel="stylesheet" href="/style/main.css" type="text/css" />
<?php

//Данные для формы (по умолчанию)
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
    
    //Подставляем данные из БД для формы редактирования
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

  //Заголовок ссылки
  $title = iconv("UTF-8", "windows-1251",  $_POST['ask_title']);
  $title = filter_var(mb_substr(trim($title), 0, 55), FILTER_SANITIZE_STRING);
  
  //Краткое описание ссылки
  $desc = iconv("UTF-8", "windows-1251",  $_POST['ask_desc']);
  $desc = filter_var(mb_substr(trim($desc),0 ,55), FILTER_SANITIZE_STRING);

  //URL сайта
  $url = isset($_POST['ask_url']) ? trim($_POST['ask_url']) : ''; 
  if (!filter_var($url, FILTER_VALIDATE_URL)) { echo '<span class="msgbox-error">Неверный адрес сайта</span>'; return; }
  
  //Время просмотра ссылки
  $timer = isset($_POST['ask_timer']) ? (int)$_POST['ask_timer'] : 20;
  $timer_arr = array('20' => 20, '30' => 30, '40' => 40, '50' => 50, '60' => 60);
  if (!isset($timer_arr[$timer])) { echo '<span class="msgbox-error">Ошибка данных</span>'; return; }
  
  //Последующий переход на сайт
  $move = isset($_POST['ask_move']) ? (int)$_POST['ask_move'] : 0;
  if ($move > 1 || $move < 0) { echo '<span class="msgbox-error">Ошибка данных</span>'; return; }
  
  //Выделить ссылку
  $high = isset($_POST['ask_high']) ? (int)$_POST['ask_high'] : 0;
  if ($high > 1 || $high < 0) { echo '<span class="msgbox-error">Ошибка данных</span>'; return; }
  
  //Аудитория смотрящих
  $speed = isset($_POST['ask_speed']) ? (int)$_POST['ask_speed'] : 0;
  if ($speed > 7 || $speed < 1) { echo '<span class="msgbox-error">Ошибка данных</span>'; return; }
  
  //По рейтингу
  $rating = isset($_POST['ask_rating']) ? (int)$_POST['ask_rating'] : 0;
  $rating_arr = array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5);
  if (!isset($rating_arr[$rating])) { echo '<span class="msgbox-error">Ошибка данных</span>'; return; }
  
  //$kolvo = (int)$_POST['ask_kolvo'];
  
  //Доступность по странам
  $country1 = isset($_POST['ask_country1']) ? filter_var(mb_substr($_POST['ask_country1'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country2 = isset($_POST['ask_country2']) ? filter_var(mb_substr($_POST['ask_country2'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country3 = isset($_POST['ask_country3']) ? filter_var(mb_substr($_POST['ask_country3'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country4 = isset($_POST['ask_country4']) ? filter_var(mb_substr($_POST['ask_country4'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  $country5 = isset($_POST['ask_country5']) ? filter_var(mb_substr($_POST['ask_country5'], 0, 2), FILTER_SANITIZE_STRING) : 'xx';
  
  $country = '';
  
  $crev = isset($_POST['ask_crev']) ? (int)$_POST['ask_crev'] : 0;
  
  if ($crev > 1 || $crev < 0) { echo '<span class="msgbox-error">Ошибка данных</span>'; return; }
  
  if ($country1 != 'xx' || $country2 != 'xx' || $country3 != 'xx' || $country4 != 'xx' || $country5 != 'xx') 
  { 
    $country = $country1.'|'.$country2.'|'.$country3.'|'.$country4.'|'.$country5; 
  }
  
  //Если не заполнены основные поля
  if ($title == '' || $desc == '' || $url == '') { echo '<span class="msgbox-error">Заполнены не все поля</span>'; return; }
  
  //Расчёт стоимости просмотра
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
  
    //echo '<span class="msgbox-success">Ссылка добавлена</span>';
  
    header('Location: /account/serfing/cabinet'); exit();
  }  
} 

//end:

?>
<script>
 function SbmForm() {
    if (document.forms['surforder'].ask_title.value == '') {
        alert('Вы не указали заголовок ссылки');
        document.forms['surforder'].ask_title.focus();
        return false;
    }
    if (document.forms['surforder'].ask_desc.value == '') {
        alert('Вы не указали краткое описание ссылки');
        document.forms['surforder'].ask_desc.focus();
        return false;
    }
    if ((document.forms['surforder'].ask_url.value == '')|(document.forms['surforder'].ask_url.value == 'http://')) {
        alert('Вы не указали URL-адрес ссылки');
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
	<div class="acc-title9">Добавить Серфинг</div>
</div>

<div class="silver-bk">
    <p>Категорически запрещено размещение рекламных ссылок на ресурсы:</p>
    <ul class="arrowred">
        <li>содержащие вирусы и фишинговые сайты/ссылки</li>
        <li>сайты с редиректом на другие сайты, включая редирект сайта-источника</li>
        <li>разрушающие фрейм с таймером</li>
        <li>содержащие порнографию или обилие эротических материалов</li>
        <li>содержащие нецензурную и ненормативную лексику</li>
        <li>секс-шопы и доски знакомств типа "на одну ночь"</li>
        <li>сообщества нетрадиционной сексуальной ориентации</li>
        <li>призывающие к насилию, расизму, национализму, аморальному поведению</li>
        <li>политические и религиозные ресурсы</li>
        <li>ресурсы для сбора пожертвований, кроме официальных фондов и центров помощи</li>
        <li>ресурсы с элементами магии, спиритизма, оккультизма</li>
        <li>ресурсы, с явно выраженным обманом</li>
        <li>ресурсы, созданные "не для людей", т.е. набитые множеством партнёрок, всплывающих pop-up и т.д.</li>
        <li>ресурсы, требующие отправку платных СМС-сообщений</li>
        <li>сайты, которые неоправданно долго загружаются, вследствие слабого хостинга или обилия скрытых партнёрок</li>
        <li>ресурсы, нарушающие законодательство РФ</li>
    </ul>
    <p style="color: red; font-weight: bold;">В случаях не выполнения правил БАН аккаунта без предупреждения и возмещения убытков.</p>

 <div id="entermsg"><?php if (!empty($msg)) { echo $msg; } ?></div>

<form accept-charset="utf-8"  name="surforder" method="post" action="/account/serfing/add" >

    <span id="cattitle2" class="cattitle-new">Форма описания рекламной площадки</span>

<div id="catblock2">

    <input type="hidden" name="ask_editcode" value="<?php echo $advedit; ?>" />

    <table class='profile' style='margin-bottom: 0;'>
        <tbody>
            <tr>
                <td><b>Заголовок ссылки</b></td>
                <td class="value"><input class="val" type="text" name="ask_title" maxlength="55" value="<?php echo $title; ?>" /></td>
                <td class="service"></td>
            </tr>
            <tr>
                <td><b>Краткое описание ссылки</b></td>
                <td class="value"><input class="val" type="text" name="ask_desc" maxlength="55" value="<?php echo $desc; ?>" /></td>
                <td class="service"></td>
            </tr>
            <tr>
                <td><b>URL сайта</b> (включая http://)</td>
                <td class="value"><input class="val" type="text" name="ask_url" maxlength="300" value="<?php echo $url; ?>" /></td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>Время просмотра ссылки</td>
                <td class="value">
                    <select class="val" name="ask_timer" onChange="PlanChange(this.form); return false;">
                        <option value="20">20 секунд</option>
                        <option value="30">30 секунд&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER; ?> сер.)</option>
                        <option value="40">40 секунд&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER*2; ?> сер.)</option>
                        <option value="50">50 секунд&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER*3; ?> сер.)</option>
                        <option value="60">60 секунд&nbsp;&nbsp;(+ <?php echo SERF_PRICE_TIMER*4; ?> сер.)</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>Выделить ссылку</td>
                <td class="value">
                    <select class="val" name="ask_high" onChange="PlanChange(this.form); return false;">
                        <option value="0">Нет</option>
                        <option value="1">Да&nbsp;&nbsp;(+ <?php echo SERF_PRICE_HIGH; ?> сер.)</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>Последующий переход на сайт</td>
                <td class="value">
                    <select class="val" name="ask_move" onChange="PlanChange(this.form); return false;">
                        <option value="0">Нет</option>
                        <option value="1">Да&nbsp;&nbsp;(+ <?php echo SERF_PRICE_MOVE; ?> сер.)</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr class="hidden">
                <td>Аудитория смотрящих</td>
                <td class="value">
                    <select class="val" name="ask_speed">
                        <option value="1" selected>Все пользователи проекта</option>
                        <option value="2">1/2 пользователей</option>
                        <option value="3">1/3 пользователей</option>
                        <option value="4">1/4 пользователей</option>
                        <option value="5">Очень медленный серфинг</option>
                        <option value="6">Супер медленный серфинг</option>
                        <option value="7">Черепаший серфинг</option>
                    </select>
                </td>
                <td class="service"></td>
            </tr>
            <tr>
                <td>Стоимость одного просмотра</td>
                <td class="price" colspan="2">
                <input type="text" name="linkprice" maxlength="5" value="" readonly="readonly" /> серебра.
                </td>
            </tr>
        </tbody>
    </table>
</div>

    <span id="cattitle3" class="cattitle-open hidden" onclick="showhide(3);">Расширенный выбор целевой аудитории, таргетинг (+ <?php echo SERF_PRICE_TARGET; ?> бак.)</span>

<div id="catblock3" style="margin-bottom: 20px; display: none; ">
    <table class='profile' width='100%' border='0' cellpadding='0' cellspacing='0' style="margin-bottom: 0;">
        <tr>
            <td>По рейтингу</td>
            <td class="value">
                <select class="val" name="ask_rating" onChange="PlanChange(this.form); return false;">
                    <option value="0" selected="selected">Все пользователи</option>
                    <option value="1">Стажёр</option>
                    <option value="2">ГОНЩИК 3 класса</option>
                    <option value="3">ГОНЩИК 2 класса</option>
                    <option value="4">ГОНЩИК 1 класса</option>
                    <option value="5">StreetRacer</option>
                </select>
            </td>
            <td class="service"></td>
        </tr>
        <tr>
            <td><b>Доступность по странам</b></td>
            <td class="value">
                <select class="val" name="ask_crev">
                    <option value="0" selected="selected">Показывать только указанным ниже странам</option>
                    <option value="1">Показывать всем, кроме указанным ниже странам</option>
                </select>
            </td>
            <td class="service"></td>
        </tr>
        <tr>
            <td width='44%'>Выбор стран</td>
            <td class="value">
                <select class="country" name="ask_country1" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">Не указано</option>
                    <option value="AU">Австралия</option><option value="AT">Австрия</option><option value="AZ">Азербайджан</option><option value="AP">Азиатско-Тихоокеанский регион</option><option value="AX">Аландские острова</option><option value="AL">Албания</option><option value="DZ">Алжир</option><option value="VI">Американские Виргинские острова</option><option value="AS">Американское Самоа</option><option value="AI">Ангилья</option><option value="AO">Ангола</option><option value="AD">Андорра</option><option value="AQ">Антарктида</option><option value="AG">Антигуа и Барбуда</option><option value="AR">Аргентина</option><option value="AM">Армения</option><option value="AW">Аруба</option><option value="AF">Афганистан</option><option value="BS">Багамы</option><option value="BD">Бангладеш</option><option value="BB">Барбадос</option><option value="BH">Бахрейн</option><option value="BY">Беларусь</option><option value="BZ">Белиз</option><option value="BE">Бельгия</option><option value="BJ">Бенин</option><option value="BM">Бермуды</option><option value="BG">Болгария</option><option value="BO">Боливия</option><option value="BA">Босния и Герцеговина</option><option value="BW">Ботсвана</option><option value="BR">Бразилия</option><option value="IO">Британская территория в Индийском океане</option><option value="VG">Британские Виргинские острова</option><option value="BN">Бруней</option><option value="BF">Буркина-Фасо</option><option value="BI">Бурунди</option><option value="BT">Бутан</option><option value="VU">Вануату</option><option value="VA">Ватикан</option><option value="GB">Великобритания</option><option value="HU">Венгрия</option><option value="VE">Венесуэла</option><option value="UM">Внешние малые острова (США)</option><option value="TL">Восточный Тимор</option><option value="VN">Вьетнам</option><option value="GA">Габон</option><option value="HT">Гаити</option><option value="GY">Гайана</option><option value="GM">Гамбия</option><option value="GH">Гана</option><option value="GP">Гваделупа</option><option value="GT">Гватемала</option><option value="GN">Гвинея</option><option value="GW">Гвинея-Бисау</option><option value="DE">Германия</option><option value="GG">Гернси</option><option value="GI">Гибралтар</option><option value="HN">Гондурас</option><option value="HK">Гонконг</option><option value="GD">Гренада</option><option value="GL">Гренландия</option><option value="GR">Греция</option><option value="GE">Грузия</option><option value="GU">Гуам</option><option value="DK">Дания</option><option value="CD">Демократическая Республика Конго</option><option value="JE">Джерси</option><option value="DJ">Джибути</option><option value="DM">Доминика</option><option value="DO">Доминиканская Республика</option><option value="EU">Неизвестно</option><option value="EG">Египет</option><option value="ZM">Замбия</option><option value="ZW">Зимбабве</option><option value="IL">Израиль</option><option value="IN">Индия</option><option value="ID">Индонезия</option><option value="JO">Иордания</option><option value="IQ">Ирак</option><option value="IR">Иран</option><option value="IE">Ирландия</option><option value="IS">Исландия</option><option value="ES">Испания</option><option value="IT">Италия</option><option value="YE">Йемен</option><option value="CV">Кабо-Верде</option><option value="KZ">Казахстан</option><option value="KY">Каймановы острова</option><option value="KH">Камбоджа</option><option value="CM">Камерун</option><option value="CA">Канада</option><option value="QA">Катар</option><option value="KE">Кения</option><option value="CY">Кипр</option><option value="KI">Кирибати</option><option value="CN">Китай</option><option value="CO">Колумбия</option><option value="KM">Коморы</option><option value="CG">Конго</option><option value="CR">Коста-Рика</option><option value="CI">Кот-д’Ивуар</option><option value="CU">Куба</option><option value="KW">Кувейт</option><option value="KG">Кыргызстан</option><option value="LA">Лаос</option><option value="LV">Латвия</option><option value="LS">Лесото</option><option value="LR">Либерия</option><option value="LB">Ливан</option><option value="LY">Ливия</option><option value="LT">Литва</option><option value="LI">Лихтенштейн</option><option value="LU">Люксембург</option><option value="MU">Маврикий</option><option value="MR">Мавритания</option><option value="MG">Мадагаскар</option><option value="YT">Майотта</option><option value="MO">Макао</option><option value="MK">Македония</option><option value="MW">Малави</option><option value="MY">Малайзия</option><option value="ML">Мали</option><option value="MV">Мальдивы</option><option value="MT">Мальта</option><option value="MA">Марокко</option><option value="MQ">Мартиника</option><option value="MH">Маршалловы острова</option><option value="MX">Мексика</option><option value="FM">Микронезия</option><option value="MZ">Мозамбик</option><option value="MD">Молдавия</option><option value="MC">Монако</option><option value="MN">Монголия</option><option value="MS">Монтсеррат</option><option value="MM">Мьянма</option><option value="NA">Намибия</option><option value="NR">Науру</option><option value="NP">Непал</option><option value="NE">Нигер</option><option value="NG">Нигерия</option><option value="AN">Нидерландские Антильские острова</option><option value="NL">Нидерланды</option><option value="NI">Никарагуа</option><option value="NU">Ниуэ</option><option value="NZ">Новая Зеландия</option><option value="NC">Новая Каледония</option><option value="NO">Норвегия</option><option value="AE">Объединённые Арабские Эмираты</option><option value="OM">Оман</option><option value="AC">Остров Вознесения</option><option value="IM">Остров Мэн</option><option value="NF">Остров Норфолк</option><option value="CX">Остров Рождества</option><option value="SH">Остров Святой Елены</option><option value="HM">Остров Херд и Острова Макдоналд</option><option value="CK">Острова Кука</option><option value="WF">Острова Уоллис и Футуна</option><option value="PK">Пакистан</option><option value="PW">Палау</option><option value="PS">Палестина</option><option value="PA">Панама</option><option value="PG">Папуа-Новая Гвинея</option><option value="PY">Парагвай</option><option value="PE">Перу</option><option value="PL">Польша</option><option value="PT">Португалия</option><option value="PR">Пуэрто-Рико</option><option value="RE">Реюньон</option><option value="RU">Россия</option><option value="RW">Руанда</option><option value="RO">Румыния</option><option value="SV">Сальвадор</option><option value="WS">Самоа</option><option value="SM">Сан-Марино</option><option value="ST">Сан-Томе и Принсипи</option><option value="SA">Саудовская Аравия</option><option value="SZ">Свазиленд</option><option value="KP">Северная Корея</option><option value="MP">Северные Марианские острова</option><option value="SC">Сейшелы</option><option value="MF">Сен-Мартен</option><option value="PM">Сен-Пьер и Микелон</option><option value="SN">Сенегал</option><option value="VC">Сент-Винсент и Гренадины</option><option value="KN">Сент-Киттс и Невис</option><option value="LC">Сент-Люсия</option><option value="RS">Сербия</option><option value="SG">Сингапур</option><option value="SY">Сирия</option><option value="SK">Словакия</option><option value="SI">Словения</option><option value="US">Соединённые Штаты Америки</option><option value="SB">Соломоновы Острова</option><option value="SO">Сомали</option><option value="SD">Судан</option><option value="SR">Суринам</option><option value="SL">Сьерра-Леоне</option><option value="TJ">Таджикистан</option><option value="TH">Таиланд</option><option value="TW">Тайвань</option><option value="TZ">Танзания</option><option value="TC">Тёркс и Кайкос</option><option value="TG">Того</option><option value="TK">Токелау</option><option value="TO">Тонга</option><option value="TT">Тринидад и Тобаго</option><option value="TV">Тувалу</option><option value="TN">Тунис</option><option value="TM">Туркмения</option><option value="TR">Турция</option><option value="UG">Уганда</option><option value="UZ">Узбекистан</option><option value="UA">Украина</option><option value="UY">Уругвай</option><option value="FO">Фарерские острова</option><option value="FJ">Фиджи</option><option value="PH">Филиппины</option><option value="FI">Финляндия</option><option value="FK">Фолклендские острова</option><option value="FR">Франция</option><option value="GF">Французская Гвиана</option><option value="PF">Французская Полинезия</option><option value="HR">Хорватия</option><option value="CF">Центральноафриканская Республика</option><option value="TD">Чад</option><option value="ME">Черногория</option><option value="CZ">Чехия</option><option value="CL">Чили</option><option value="CH">Швейцария</option><option value="SE">Швеция</option><option value="LK">Шри-Ланка</option><option value="EC">Эквадор</option><option value="GQ">Экваториальная Гвинея</option><option value="ER">Эритрея</option><option value="EE">Эстония</option><option value="ET">Эфиопия</option><option value="ZA">Южная Африка</option><option value="KR">Южная Корея</option><option value="JM">Ямайка</option><option value="JP">Япония</option><option value="XX">Неизвестно</option><option value="00">Неизвестно</option><option value="">Неизвестно</option>
                </select>
                <select class="country" name="ask_country2" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">Не указано</option>
                    <option value="AU">Австралия</option><option value="AT">Австрия</option><option value="AZ">Азербайджан</option><option value="AP">Азиатско-Тихоокеанский регион</option><option value="AX">Аландские острова</option><option value="AL">Албания</option><option value="DZ">Алжир</option><option value="VI">Американские Виргинские острова</option><option value="AS">Американское Самоа</option><option value="AI">Ангилья</option><option value="AO">Ангола</option><option value="AD">Андорра</option><option value="AQ">Антарктида</option><option value="AG">Антигуа и Барбуда</option><option value="AR">Аргентина</option><option value="AM">Армения</option><option value="AW">Аруба</option><option value="AF">Афганистан</option><option value="BS">Багамы</option><option value="BD">Бангладеш</option><option value="BB">Барбадос</option><option value="BH">Бахрейн</option><option value="BY">Беларусь</option><option value="BZ">Белиз</option><option value="BE">Бельгия</option><option value="BJ">Бенин</option><option value="BM">Бермуды</option><option value="BG">Болгария</option><option value="BO">Боливия</option><option value="BA">Босния и Герцеговина</option><option value="BW">Ботсвана</option><option value="BR">Бразилия</option><option value="IO">Британская территория в Индийском океане</option><option value="VG">Британские Виргинские острова</option><option value="BN">Бруней</option><option value="BF">Буркина-Фасо</option><option value="BI">Бурунди</option><option value="BT">Бутан</option><option value="VU">Вануату</option><option value="VA">Ватикан</option><option value="GB">Великобритания</option><option value="HU">Венгрия</option><option value="VE">Венесуэла</option><option value="UM">Внешние малые острова (США)</option><option value="TL">Восточный Тимор</option><option value="VN">Вьетнам</option><option value="GA">Габон</option><option value="HT">Гаити</option><option value="GY">Гайана</option><option value="GM">Гамбия</option><option value="GH">Гана</option><option value="GP">Гваделупа</option><option value="GT">Гватемала</option><option value="GN">Гвинея</option><option value="GW">Гвинея-Бисау</option><option value="DE">Германия</option><option value="GG">Гернси</option><option value="GI">Гибралтар</option><option value="HN">Гондурас</option><option value="HK">Гонконг</option><option value="GD">Гренада</option><option value="GL">Гренландия</option><option value="GR">Греция</option><option value="GE">Грузия</option><option value="GU">Гуам</option><option value="DK">Дания</option><option value="CD">Демократическая Республика Конго</option><option value="JE">Джерси</option><option value="DJ">Джибути</option><option value="DM">Доминика</option><option value="DO">Доминиканская Республика</option><option value="EU">Неизвестно</option><option value="EG">Египет</option><option value="ZM">Замбия</option><option value="ZW">Зимбабве</option><option value="IL">Израиль</option><option value="IN">Индия</option><option value="ID">Индонезия</option><option value="JO">Иордания</option><option value="IQ">Ирак</option><option value="IR">Иран</option><option value="IE">Ирландия</option><option value="IS">Исландия</option><option value="ES">Испания</option><option value="IT">Италия</option><option value="YE">Йемен</option><option value="CV">Кабо-Верде</option><option value="KZ">Казахстан</option><option value="KY">Каймановы острова</option><option value="KH">Камбоджа</option><option value="CM">Камерун</option><option value="CA">Канада</option><option value="QA">Катар</option><option value="KE">Кения</option><option value="CY">Кипр</option><option value="KI">Кирибати</option><option value="CN">Китай</option><option value="CO">Колумбия</option><option value="KM">Коморы</option><option value="CG">Конго</option><option value="CR">Коста-Рика</option><option value="CI">Кот-д’Ивуар</option><option value="CU">Куба</option><option value="KW">Кувейт</option><option value="KG">Кыргызстан</option><option value="LA">Лаос</option><option value="LV">Латвия</option><option value="LS">Лесото</option><option value="LR">Либерия</option><option value="LB">Ливан</option><option value="LY">Ливия</option><option value="LT">Литва</option><option value="LI">Лихтенштейн</option><option value="LU">Люксембург</option><option value="MU">Маврикий</option><option value="MR">Мавритания</option><option value="MG">Мадагаскар</option><option value="YT">Майотта</option><option value="MO">Макао</option><option value="MK">Македония</option><option value="MW">Малави</option><option value="MY">Малайзия</option><option value="ML">Мали</option><option value="MV">Мальдивы</option><option value="MT">Мальта</option><option value="MA">Марокко</option><option value="MQ">Мартиника</option><option value="MH">Маршалловы острова</option><option value="MX">Мексика</option><option value="FM">Микронезия</option><option value="MZ">Мозамбик</option><option value="MD">Молдавия</option><option value="MC">Монако</option><option value="MN">Монголия</option><option value="MS">Монтсеррат</option><option value="MM">Мьянма</option><option value="NA">Намибия</option><option value="NR">Науру</option><option value="NP">Непал</option><option value="NE">Нигер</option><option value="NG">Нигерия</option><option value="AN">Нидерландские Антильские острова</option><option value="NL">Нидерланды</option><option value="NI">Никарагуа</option><option value="NU">Ниуэ</option><option value="NZ">Новая Зеландия</option><option value="NC">Новая Каледония</option><option value="NO">Норвегия</option><option value="AE">Объединённые Арабские Эмираты</option><option value="OM">Оман</option><option value="AC">Остров Вознесения</option><option value="IM">Остров Мэн</option><option value="NF">Остров Норфолк</option><option value="CX">Остров Рождества</option><option value="SH">Остров Святой Елены</option><option value="HM">Остров Херд и Острова Макдоналд</option><option value="CK">Острова Кука</option><option value="WF">Острова Уоллис и Футуна</option><option value="PK">Пакистан</option><option value="PW">Палау</option><option value="PS">Палестина</option><option value="PA">Панама</option><option value="PG">Папуа-Новая Гвинея</option><option value="PY">Парагвай</option><option value="PE">Перу</option><option value="PL">Польша</option><option value="PT">Португалия</option><option value="PR">Пуэрто-Рико</option><option value="RE">Реюньон</option><option value="RU">Россия</option><option value="RW">Руанда</option><option value="RO">Румыния</option><option value="SV">Сальвадор</option><option value="WS">Самоа</option><option value="SM">Сан-Марино</option><option value="ST">Сан-Томе и Принсипи</option><option value="SA">Саудовская Аравия</option><option value="SZ">Свазиленд</option><option value="KP">Северная Корея</option><option value="MP">Северные Марианские острова</option><option value="SC">Сейшелы</option><option value="MF">Сен-Мартен</option><option value="PM">Сен-Пьер и Микелон</option><option value="SN">Сенегал</option><option value="VC">Сент-Винсент и Гренадины</option><option value="KN">Сент-Киттс и Невис</option><option value="LC">Сент-Люсия</option><option value="RS">Сербия</option><option value="SG">Сингапур</option><option value="SY">Сирия</option><option value="SK">Словакия</option><option value="SI">Словения</option><option value="US">Соединённые Штаты Америки</option><option value="SB">Соломоновы Острова</option><option value="SO">Сомали</option><option value="SD">Судан</option><option value="SR">Суринам</option><option value="SL">Сьерра-Леоне</option><option value="TJ">Таджикистан</option><option value="TH">Таиланд</option><option value="TW">Тайвань</option><option value="TZ">Танзания</option><option value="TC">Тёркс и Кайкос</option><option value="TG">Того</option><option value="TK">Токелау</option><option value="TO">Тонга</option><option value="TT">Тринидад и Тобаго</option><option value="TV">Тувалу</option><option value="TN">Тунис</option><option value="TM">Туркмения</option><option value="TR">Турция</option><option value="UG">Уганда</option><option value="UZ">Узбекистан</option><option value="UA">Украина</option><option value="UY">Уругвай</option><option value="FO">Фарерские острова</option><option value="FJ">Фиджи</option><option value="PH">Филиппины</option><option value="FI">Финляндия</option><option value="FK">Фолклендские острова</option><option value="FR">Франция</option><option value="GF">Французская Гвиана</option><option value="PF">Французская Полинезия</option><option value="HR">Хорватия</option><option value="CF">Центральноафриканская Республика</option><option value="TD">Чад</option><option value="ME">Черногория</option><option value="CZ">Чехия</option><option value="CL">Чили</option><option value="CH">Швейцария</option><option value="SE">Швеция</option><option value="LK">Шри-Ланка</option><option value="EC">Эквадор</option><option value="GQ">Экваториальная Гвинея</option><option value="ER">Эритрея</option><option value="EE">Эстония</option><option value="ET">Эфиопия</option><option value="ZA">Южная Африка</option><option value="KR">Южная Корея</option><option value="JM">Ямайка</option><option value="JP">Япония</option><option value="XX">Неизвестно</option><option value="00">Неизвестно</option><option value="">Неизвестно</option>
                </select>
                <select class="country" name="ask_country3" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">Не указано</option>
                    <option value="AU">Австралия</option><option value="AT">Австрия</option><option value="AZ">Азербайджан</option><option value="AP">Азиатско-Тихоокеанский регион</option><option value="AX">Аландские острова</option><option value="AL">Албания</option><option value="DZ">Алжир</option><option value="VI">Американские Виргинские острова</option><option value="AS">Американское Самоа</option><option value="AI">Ангилья</option><option value="AO">Ангола</option><option value="AD">Андорра</option><option value="AQ">Антарктида</option><option value="AG">Антигуа и Барбуда</option><option value="AR">Аргентина</option><option value="AM">Армения</option><option value="AW">Аруба</option><option value="AF">Афганистан</option><option value="BS">Багамы</option><option value="BD">Бангладеш</option><option value="BB">Барбадос</option><option value="BH">Бахрейн</option><option value="BY">Беларусь</option><option value="BZ">Белиз</option><option value="BE">Бельгия</option><option value="BJ">Бенин</option><option value="BM">Бермуды</option><option value="BG">Болгария</option><option value="BO">Боливия</option><option value="BA">Босния и Герцеговина</option><option value="BW">Ботсвана</option><option value="BR">Бразилия</option><option value="IO">Британская территория в Индийском океане</option><option value="VG">Британские Виргинские острова</option><option value="BN">Бруней</option><option value="BF">Буркина-Фасо</option><option value="BI">Бурунди</option><option value="BT">Бутан</option><option value="VU">Вануату</option><option value="VA">Ватикан</option><option value="GB">Великобритания</option><option value="HU">Венгрия</option><option value="VE">Венесуэла</option><option value="UM">Внешние малые острова (США)</option><option value="TL">Восточный Тимор</option><option value="VN">Вьетнам</option><option value="GA">Габон</option><option value="HT">Гаити</option><option value="GY">Гайана</option><option value="GM">Гамбия</option><option value="GH">Гана</option><option value="GP">Гваделупа</option><option value="GT">Гватемала</option><option value="GN">Гвинея</option><option value="GW">Гвинея-Бисау</option><option value="DE">Германия</option><option value="GG">Гернси</option><option value="GI">Гибралтар</option><option value="HN">Гондурас</option><option value="HK">Гонконг</option><option value="GD">Гренада</option><option value="GL">Гренландия</option><option value="GR">Греция</option><option value="GE">Грузия</option><option value="GU">Гуам</option><option value="DK">Дания</option><option value="CD">Демократическая Республика Конго</option><option value="JE">Джерси</option><option value="DJ">Джибути</option><option value="DM">Доминика</option><option value="DO">Доминиканская Республика</option><option value="EU">Неизвестно</option><option value="EG">Египет</option><option value="ZM">Замбия</option><option value="ZW">Зимбабве</option><option value="IL">Израиль</option><option value="IN">Индия</option><option value="ID">Индонезия</option><option value="JO">Иордания</option><option value="IQ">Ирак</option><option value="IR">Иран</option><option value="IE">Ирландия</option><option value="IS">Исландия</option><option value="ES">Испания</option><option value="IT">Италия</option><option value="YE">Йемен</option><option value="CV">Кабо-Верде</option><option value="KZ">Казахстан</option><option value="KY">Каймановы острова</option><option value="KH">Камбоджа</option><option value="CM">Камерун</option><option value="CA">Канада</option><option value="QA">Катар</option><option value="KE">Кения</option><option value="CY">Кипр</option><option value="KI">Кирибати</option><option value="CN">Китай</option><option value="CO">Колумбия</option><option value="KM">Коморы</option><option value="CG">Конго</option><option value="CR">Коста-Рика</option><option value="CI">Кот-д’Ивуар</option><option value="CU">Куба</option><option value="KW">Кувейт</option><option value="KG">Кыргызстан</option><option value="LA">Лаос</option><option value="LV">Латвия</option><option value="LS">Лесото</option><option value="LR">Либерия</option><option value="LB">Ливан</option><option value="LY">Ливия</option><option value="LT">Литва</option><option value="LI">Лихтенштейн</option><option value="LU">Люксембург</option><option value="MU">Маврикий</option><option value="MR">Мавритания</option><option value="MG">Мадагаскар</option><option value="YT">Майотта</option><option value="MO">Макао</option><option value="MK">Македония</option><option value="MW">Малави</option><option value="MY">Малайзия</option><option value="ML">Мали</option><option value="MV">Мальдивы</option><option value="MT">Мальта</option><option value="MA">Марокко</option><option value="MQ">Мартиника</option><option value="MH">Маршалловы острова</option><option value="MX">Мексика</option><option value="FM">Микронезия</option><option value="MZ">Мозамбик</option><option value="MD">Молдавия</option><option value="MC">Монако</option><option value="MN">Монголия</option><option value="MS">Монтсеррат</option><option value="MM">Мьянма</option><option value="NA">Намибия</option><option value="NR">Науру</option><option value="NP">Непал</option><option value="NE">Нигер</option><option value="NG">Нигерия</option><option value="AN">Нидерландские Антильские острова</option><option value="NL">Нидерланды</option><option value="NI">Никарагуа</option><option value="NU">Ниуэ</option><option value="NZ">Новая Зеландия</option><option value="NC">Новая Каледония</option><option value="NO">Норвегия</option><option value="AE">Объединённые Арабские Эмираты</option><option value="OM">Оман</option><option value="AC">Остров Вознесения</option><option value="IM">Остров Мэн</option><option value="NF">Остров Норфолк</option><option value="CX">Остров Рождества</option><option value="SH">Остров Святой Елены</option><option value="HM">Остров Херд и Острова Макдоналд</option><option value="CK">Острова Кука</option><option value="WF">Острова Уоллис и Футуна</option><option value="PK">Пакистан</option><option value="PW">Палау</option><option value="PS">Палестина</option><option value="PA">Панама</option><option value="PG">Папуа-Новая Гвинея</option><option value="PY">Парагвай</option><option value="PE">Перу</option><option value="PL">Польша</option><option value="PT">Португалия</option><option value="PR">Пуэрто-Рико</option><option value="RE">Реюньон</option><option value="RU">Россия</option><option value="RW">Руанда</option><option value="RO">Румыния</option><option value="SV">Сальвадор</option><option value="WS">Самоа</option><option value="SM">Сан-Марино</option><option value="ST">Сан-Томе и Принсипи</option><option value="SA">Саудовская Аравия</option><option value="SZ">Свазиленд</option><option value="KP">Северная Корея</option><option value="MP">Северные Марианские острова</option><option value="SC">Сейшелы</option><option value="MF">Сен-Мартен</option><option value="PM">Сен-Пьер и Микелон</option><option value="SN">Сенегал</option><option value="VC">Сент-Винсент и Гренадины</option><option value="KN">Сент-Киттс и Невис</option><option value="LC">Сент-Люсия</option><option value="RS">Сербия</option><option value="SG">Сингапур</option><option value="SY">Сирия</option><option value="SK">Словакия</option><option value="SI">Словения</option><option value="US">Соединённые Штаты Америки</option><option value="SB">Соломоновы Острова</option><option value="SO">Сомали</option><option value="SD">Судан</option><option value="SR">Суринам</option><option value="SL">Сьерра-Леоне</option><option value="TJ">Таджикистан</option><option value="TH">Таиланд</option><option value="TW">Тайвань</option><option value="TZ">Танзания</option><option value="TC">Тёркс и Кайкос</option><option value="TG">Того</option><option value="TK">Токелау</option><option value="TO">Тонга</option><option value="TT">Тринидад и Тобаго</option><option value="TV">Тувалу</option><option value="TN">Тунис</option><option value="TM">Туркмения</option><option value="TR">Турция</option><option value="UG">Уганда</option><option value="UZ">Узбекистан</option><option value="UA">Украина</option><option value="UY">Уругвай</option><option value="FO">Фарерские острова</option><option value="FJ">Фиджи</option><option value="PH">Филиппины</option><option value="FI">Финляндия</option><option value="FK">Фолклендские острова</option><option value="FR">Франция</option><option value="GF">Французская Гвиана</option><option value="PF">Французская Полинезия</option><option value="HR">Хорватия</option><option value="CF">Центральноафриканская Республика</option><option value="TD">Чад</option><option value="ME">Черногория</option><option value="CZ">Чехия</option><option value="CL">Чили</option><option value="CH">Швейцария</option><option value="SE">Швеция</option><option value="LK">Шри-Ланка</option><option value="EC">Эквадор</option><option value="GQ">Экваториальная Гвинея</option><option value="ER">Эритрея</option><option value="EE">Эстония</option><option value="ET">Эфиопия</option><option value="ZA">Южная Африка</option><option value="KR">Южная Корея</option><option value="JM">Ямайка</option><option value="JP">Япония</option><option value="XX">Неизвестно</option><option value="00">Неизвестно</option><option value="">Неизвестно</option>
                </select>
                <select class="country" name="ask_country4" onChange="PlanChange(this.form); return false;">
                    <option value="xx" selected="selected">Не указано</option>
                    <option value="AU">Австралия</option><option value="AT">Австрия</option><option value="AZ">Азербайджан</option><option value="AP">Азиатско-Тихоокеанский регион</option><option value="AX">Аландские острова</option><option value="AL">Албания</option><option value="DZ">Алжир</option><option value="VI">Американские Виргинские острова</option><option value="AS">Американское Самоа</option><option value="AI">Ангилья</option><option value="AO">Ангола</option><option value="AD">Андорра</option><option value="AQ">Антарктида</option><option value="AG">Антигуа и Барбуда</option><option value="AR">Аргентина</option><option value="AM">Армения</option><option value="AW">Аруба</option><option value="AF">Афганистан</option><option value="BS">Багамы</option><option value="BD">Бангладеш</option><option value="BB">Барбадос</option><option value="BH">Бахрейн</option><option value="BY">Беларусь</option><option value="BZ">Белиз</option><option value="BE">Бельгия</option><option value="BJ">Бенин</option><option value="BM">Бермуды</option><option value="BG">Болгария</option><option value="BO">Боливия</option><option value="BA">Босния и Герцеговина</option><option value="BW">Ботсвана</option><option value="BR">Бразилия</option><option value="IO">Британская территория в Индийском океане</option><option value="VG">Британские Виргинские острова</option><option value="BN">Бруней</option><option value="BF">Буркина-Фасо</option><option value="BI">Бурунди</option><option value="BT">Бутан</option><option value="VU">Вануату</option><option value="VA">Ватикан</option><option value="GB">Великобритания</option><option value="HU">Венгрия</option><option value="VE">Венесуэла</option><option value="UM">Внешние малые острова (США)</option><option value="TL">Восточный Тимор</option><option value="VN">Вьетнам</option><option value="GA">Габон</option><option value="HT">Гаити</option><option value="GY">Гайана</option><option value="GM">Гамбия</option><option value="GH">Гана</option><option value="GP">Гваделупа</option><option value="GT">Гватемала</option><option value="GN">Гвинея</option><option value="GW">Гвинея-Бисау</option><option value="DE">Германия</option><option value="GG">Гернси</option><option value="GI">Гибралтар</option><option value="HN">Гондурас</option><option value="HK">Гонконг</option><option value="GD">Гренада</option><option value="GL">Гренландия</option><option value="GR">Греция</option><option value="GE">Грузия</option><option value="GU">Гуам</option><option value="DK">Дания</option><option value="CD">Демократическая Республика Конго</option><option value="JE">Джерси</option><option value="DJ">Джибути</option><option value="DM">Доминика</option><option value="DO">Доминиканская Республика</option><option value="EU">Неизвестно</option><option value="EG">Египет</option><option value="ZM">Замбия</option><option value="ZW">Зимбабве</option><option value="IL">Израиль</option><option value="IN">Индия</option><option value="ID">Индонезия</option><option value="JO">Иордания</option><option value="IQ">Ирак</option><option value="IR">Иран</option><option value="IE">Ирландия</option><option value="IS">Исландия</option><option value="ES">Испания</option><option value="IT">Италия</option><option value="YE">Йемен</option><option value="CV">Кабо-Верде</option><option value="KZ">Казахстан</option><option value="KY">Каймановы острова</option><option value="KH">Камбоджа</option><option value="CM">Камерун</option><option value="CA">Канада</option><option value="QA">Катар</option><option value="KE">Кения</option><option value="CY">Кипр</option><option value="KI">Кирибати</option><option value="CN">Китай</option><option value="CO">Колумбия</option><option value="KM">Коморы</option><option value="CG">Конго</option><option value="CR">Коста-Рика</option><option value="CI">Кот-д’Ивуар</option><option value="CU">Куба</option><option value="KW">Кувейт</option><option value="KG">Кыргызстан</option><option value="LA">Лаос</option><option value="LV">Латвия</option><option value="LS">Лесото</option><option value="LR">Либерия</option><option value="LB">Ливан</option><option value="LY">Ливия</option><option value="LT">Литва</option><option value="LI">Лихтенштейн</option><option value="LU">Люксембург</option><option value="MU">Маврикий</option><option value="MR">Мавритания</option><option value="MG">Мадагаскар</option><option value="YT">Майотта</option><option value="MO">Макао</option><option value="MK">Македония</option><option value="MW">Малави</option><option value="MY">Малайзия</option><option value="ML">Мали</option><option value="MV">Мальдивы</option><option value="MT">Мальта</option><option value="MA">Марокко</option><option value="MQ">Мартиника</option><option value="MH">Маршалловы острова</option><option value="MX">Мексика</option><option value="FM">Микронезия</option><option value="MZ">Мозамбик</option><option value="MD">Молдавия</option><option value="MC">Монако</option><option value="MN">Монголия</option><option value="MS">Монтсеррат</option><option value="MM">Мьянма</option><option value="NA">Намибия</option><option value="NR">Науру</option><option value="NP">Непал</option><option value="NE">Нигер</option><option value="NG">Нигерия</option><option value="AN">Нидерландские Антильские острова</option><option value="NL">Нидерланды</option><option value="NI">Никарагуа</option><option value="NU">Ниуэ</option><option value="NZ">Новая Зеландия</option><option value="NC">Новая Каледония</option><option value="NO">Норвегия</option><option value="AE">Объединённые Арабские Эмираты</option><option value="OM">Оман</option><option value="AC">Остров Вознесения</option><option value="IM">Остров Мэн</option><option value="NF">Остров Норфолк</option><option value="CX">Остров Рождества</option><option value="SH">Остров Святой Елены</option><option value="HM">Остров Херд и Острова Макдоналд</option><option value="CK">Острова Кука</option><option value="WF">Острова Уоллис и Футуна</option><option value="PK">Пакистан</option><option value="PW">Палау</option><option value="PS">Палестина</option><option value="PA">Панама</option><option value="PG">Папуа-Новая Гвинея</option><option value="PY">Парагвай</option><option value="PE">Перу</option><option value="PL">Польша</option><option value="PT">Португалия</option><option value="PR">Пуэрто-Рико</option><option value="RE">Реюньон</option><option value="RU">Россия</option><option value="RW">Руанда</option><option value="RO">Румыния</option><option value="SV">Сальвадор</option><option value="WS">Самоа</option><option value="SM">Сан-Марино</option><option value="ST">Сан-Томе и Принсипи</option><option value="SA">Саудовская Аравия</option><option value="SZ">Свазиленд</option><option value="KP">Северная Корея</option><option value="MP">Северные Марианские острова</option><option value="SC">Сейшелы</option><option value="MF">Сен-Мартен</option><option value="PM">Сен-Пьер и Микелон</option><option value="SN">Сенегал</option><option value="VC">Сент-Винсент и Гренадины</option><option value="KN">Сент-Киттс и Невис</option><option value="LC">Сент-Люсия</option><option value="RS">Сербия</option><option value="SG">Сингапур</option><option value="SY">Сирия</option><option value="SK">Словакия</option><option value="SI">Словения</option><option value="US">Соединённые Штаты Америки</option><option value="SB">Соломоновы Острова</option><option value="SO">Сомали</option><option value="SD">Судан</option><option value="SR">Суринам</option><option value="SL">Сьерра-Леоне</option><option value="TJ">Таджикистан</option><option value="TH">Таиланд</option><option value="TW">Тайвань</option><option value="TZ">Танзания</option><option value="TC">Тёркс и Кайкос</option><option value="TG">Того</option><option value="TK">Токелау</option><option value="TO">Тонга</option><option value="TT">Тринидад и Тобаго</option><option value="TV">Тувалу</option><option value="TN">Тунис</option><option value="TM">Туркмения</option><option value="TR">Турция</option><option value="UG">Уганда</option><option value="UZ">Узбекистан</option><option value="UA">Украина</option><option value="UY">Уругвай</option><option value="FO">Фарерские острова</option><option value="FJ">Фиджи</option><option value="PH">Филиппины</option><option value="FI">Финляндия</option><option value="FK">Фолклендские острова</option><option value="FR">Франция</option><option value="GF">Французская Гвиана</option><option value="PF">Французская Полинезия</option><option value="HR">Хорватия</option><option value="CF">Центральноафриканская Республика</option><option value="TD">Чад</option><option value="ME">Черногория</option><option value="CZ">Чехия</option><option value="CL">Чили</option><option value="CH">Швейцария</option><option value="SE">Швеция</option><option value="LK">Шри-Ланка</option><option value="EC">Эквадор</option><option value="GQ">Экваториальная Гвинея</option><option value="ER">Эритрея</option><option value="EE">Эстония</option><option value="ET">Эфиопия</option><option value="ZA">Южная Африка</option><option value="KR">Южная Корея</option><option value="JM">Ямайка</option><option value="JP">Япония</option><option value="XX">Неизвестно</option><option value="00">Неизвестно</option><option value="">Неизвестно</option>
                </select>
                <select class="country" name="ask_country5" onChange="PlanChange(this.form); return false;">
                <option value="xx" selected="selected">Не указано</option>
                <option value="AU">Австралия</option><option value="AT">Австрия</option><option value="AZ">Азербайджан</option><option value="AP">Азиатско-Тихоокеанский регион</option><option value="AX">Аландские острова</option><option value="AL">Албания</option><option value="DZ">Алжир</option><option value="VI">Американские Виргинские острова</option><option value="AS">Американское Самоа</option><option value="AI">Ангилья</option><option value="AO">Ангола</option><option value="AD">Андорра</option><option value="AQ">Антарктида</option><option value="AG">Антигуа и Барбуда</option><option value="AR">Аргентина</option><option value="AM">Армения</option><option value="AW">Аруба</option><option value="AF">Афганистан</option><option value="BS">Багамы</option><option value="BD">Бангладеш</option><option value="BB">Барбадос</option><option value="BH">Бахрейн</option><option value="BY">Беларусь</option><option value="BZ">Белиз</option><option value="BE">Бельгия</option><option value="BJ">Бенин</option><option value="BM">Бермуды</option><option value="BG">Болгария</option><option value="BO">Боливия</option><option value="BA">Босния и Герцеговина</option><option value="BW">Ботсвана</option><option value="BR">Бразилия</option><option value="IO">Британская территория в Индийском океане</option><option value="VG">Британские Виргинские острова</option><option value="BN">Бруней</option><option value="BF">Буркина-Фасо</option><option value="BI">Бурунди</option><option value="BT">Бутан</option><option value="VU">Вануату</option><option value="VA">Ватикан</option><option value="GB">Великобритания</option><option value="HU">Венгрия</option><option value="VE">Венесуэла</option><option value="UM">Внешние малые острова (США)</option><option value="TL">Восточный Тимор</option><option value="VN">Вьетнам</option><option value="GA">Габон</option><option value="HT">Гаити</option><option value="GY">Гайана</option><option value="GM">Гамбия</option><option value="GH">Гана</option><option value="GP">Гваделупа</option><option value="GT">Гватемала</option><option value="GN">Гвинея</option><option value="GW">Гвинея-Бисау</option><option value="DE">Германия</option><option value="GG">Гернси</option><option value="GI">Гибралтар</option><option value="HN">Гондурас</option><option value="HK">Гонконг</option><option value="GD">Гренада</option><option value="GL">Гренландия</option><option value="GR">Греция</option><option value="GE">Грузия</option><option value="GU">Гуам</option><option value="DK">Дания</option><option value="CD">Демократическая Республика Конго</option><option value="JE">Джерси</option><option value="DJ">Джибути</option><option value="DM">Доминика</option><option value="DO">Доминиканская Республика</option><option value="EU">Неизвестно</option><option value="EG">Египет</option><option value="ZM">Замбия</option><option value="ZW">Зимбабве</option><option value="IL">Израиль</option><option value="IN">Индия</option><option value="ID">Индонезия</option><option value="JO">Иордания</option><option value="IQ">Ирак</option><option value="IR">Иран</option><option value="IE">Ирландия</option><option value="IS">Исландия</option><option value="ES">Испания</option><option value="IT">Италия</option><option value="YE">Йемен</option><option value="CV">Кабо-Верде</option><option value="KZ">Казахстан</option><option value="KY">Каймановы острова</option><option value="KH">Камбоджа</option><option value="CM">Камерун</option><option value="CA">Канада</option><option value="QA">Катар</option><option value="KE">Кения</option><option value="CY">Кипр</option><option value="KI">Кирибати</option><option value="CN">Китай</option><option value="CO">Колумбия</option><option value="KM">Коморы</option><option value="CG">Конго</option><option value="CR">Коста-Рика</option><option value="CI">Кот-д’Ивуар</option><option value="CU">Куба</option><option value="KW">Кувейт</option><option value="KG">Кыргызстан</option><option value="LA">Лаос</option><option value="LV">Латвия</option><option value="LS">Лесото</option><option value="LR">Либерия</option><option value="LB">Ливан</option><option value="LY">Ливия</option><option value="LT">Литва</option><option value="LI">Лихтенштейн</option><option value="LU">Люксембург</option><option value="MU">Маврикий</option><option value="MR">Мавритания</option><option value="MG">Мадагаскар</option><option value="YT">Майотта</option><option value="MO">Макао</option><option value="MK">Македония</option><option value="MW">Малави</option><option value="MY">Малайзия</option><option value="ML">Мали</option><option value="MV">Мальдивы</option><option value="MT">Мальта</option><option value="MA">Марокко</option><option value="MQ">Мартиника</option><option value="MH">Маршалловы острова</option><option value="MX">Мексика</option><option value="FM">Микронезия</option><option value="MZ">Мозамбик</option><option value="MD">Молдавия</option><option value="MC">Монако</option><option value="MN">Монголия</option><option value="MS">Монтсеррат</option><option value="MM">Мьянма</option><option value="NA">Намибия</option><option value="NR">Науру</option><option value="NP">Непал</option><option value="NE">Нигер</option><option value="NG">Нигерия</option><option value="AN">Нидерландские Антильские острова</option><option value="NL">Нидерланды</option><option value="NI">Никарагуа</option><option value="NU">Ниуэ</option><option value="NZ">Новая Зеландия</option><option value="NC">Новая Каледония</option><option value="NO">Норвегия</option><option value="AE">Объединённые Арабские Эмираты</option><option value="OM">Оман</option><option value="AC">Остров Вознесения</option><option value="IM">Остров Мэн</option><option value="NF">Остров Норфолк</option><option value="CX">Остров Рождества</option><option value="SH">Остров Святой Елены</option><option value="HM">Остров Херд и Острова Макдоналд</option><option value="CK">Острова Кука</option><option value="WF">Острова Уоллис и Футуна</option><option value="PK">Пакистан</option><option value="PW">Палау</option><option value="PS">Палестина</option><option value="PA">Панама</option><option value="PG">Папуа-Новая Гвинея</option><option value="PY">Парагвай</option><option value="PE">Перу</option><option value="PL">Польша</option><option value="PT">Португалия</option><option value="PR">Пуэрто-Рико</option><option value="RE">Реюньон</option><option value="RU">Россия</option><option value="RW">Руанда</option><option value="RO">Румыния</option><option value="SV">Сальвадор</option><option value="WS">Самоа</option><option value="SM">Сан-Марино</option><option value="ST">Сан-Томе и Принсипи</option><option value="SA">Саудовская Аравия</option><option value="SZ">Свазиленд</option><option value="KP">Северная Корея</option><option value="MP">Северные Марианские острова</option><option value="SC">Сейшелы</option><option value="MF">Сен-Мартен</option><option value="PM">Сен-Пьер и Микелон</option><option value="SN">Сенегал</option><option value="VC">Сент-Винсент и Гренадины</option><option value="KN">Сент-Киттс и Невис</option><option value="LC">Сент-Люсия</option><option value="RS">Сербия</option><option value="SG">Сингапур</option><option value="SY">Сирия</option><option value="SK">Словакия</option><option value="SI">Словения</option><option value="US">Соединённые Штаты Америки</option><option value="SB">Соломоновы Острова</option><option value="SO">Сомали</option><option value="SD">Судан</option><option value="SR">Суринам</option><option value="SL">Сьерра-Леоне</option><option value="TJ">Таджикистан</option><option value="TH">Таиланд</option><option value="TW">Тайвань</option><option value="TZ">Танзания</option><option value="TC">Тёркс и Кайкос</option><option value="TG">Того</option><option value="TK">Токелау</option><option value="TO">Тонга</option><option value="TT">Тринидад и Тобаго</option><option value="TV">Тувалу</option><option value="TN">Тунис</option><option value="TM">Туркмения</option><option value="TR">Турция</option><option value="UG">Уганда</option><option value="UZ">Узбекистан</option><option value="UA">Украина</option><option value="UY">Уругвай</option><option value="FO">Фарерские острова</option><option value="FJ">Фиджи</option><option value="PH">Филиппины</option><option value="FI">Финляндия</option><option value="FK">Фолклендские острова</option><option value="FR">Франция</option><option value="GF">Французская Гвиана</option><option value="PF">Французская Полинезия</option><option value="HR">Хорватия</option><option value="CF">Центральноафриканская Республика</option><option value="TD">Чад</option><option value="ME">Черногория</option><option value="CZ">Чехия</option><option value="CL">Чили</option><option value="CH">Швейцария</option><option value="SE">Швеция</option><option value="LK">Шри-Ланка</option><option value="EC">Эквадор</option><option value="GQ">Экваториальная Гвинея</option><option value="ER">Эритрея</option><option value="EE">Эстония</option><option value="ET">Эфиопия</option><option value="ZA">Южная Африка</option><option value="KR">Южная Корея</option><option value="JM">Ямайка</option><option value="JP">Япония</option><option value="XX">Неизвестно</option><option value="00">Неизвестно</option><option value="">Неизвестно</option>
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
    <span class="button-green" title="Принять изменения" onclick="SbmForm();">Сохранить</span>
</center>
<?php
}
else
{
?>
<center>
    <span class="button-green" title="Разместить рекламу" onclick="SbmForm();">Добавить</span>
</center>
<?php
}
?>

</form>
 
</div>

</div>
 	