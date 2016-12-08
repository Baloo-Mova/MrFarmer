<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
/*
 * Серфинг для фермы
 * Версия: 1.00
 * SKYPE: sereega393
 * Использование без оплаты ЗАПРЕЩЕНО!!!
*/
define('TIME', time());

header("Content-Type: text/html; charset=windows-1251");

$db->Query("SELECT * FROM db_users_a WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1'"); //Конфиг данные
$data_c = $db->FetchArray();

function GeoIpClient() 
{
  $xml=@simplexml_load_file('http://ipgeobase.ru:7020/geo?ip='.$_SERVER["REMOTE_ADDR"]);
  
  $country = ($xml->ip->country) ? $xml->ip->country : FALSE;
  
  if ($country)
  { 
    $_SESSION['country'] = $country;
  }
  else
  {
    $_SESSION['country'] = 'FUCK';
  }
}

if (!isset($_SESSION['country'])) { GeoIpClient(); }

//unset($_SESSION['country']);

//echo 'test = '.$_SESSION['country'];

if (isset($_GET['delete']))
{
  $id = (int)$_GET['delete'];
  
  if (isset($_SESSION['admin']))
  {
    $db->query("SELECT money, user_name FROM db_serfing WHERE id = '".$id."' LIMIT 1");
 
    $result = $db->FetchArray();
  
    $db->query("UPDATE db_users_b SET money_b = money_b + '".$result['money']."' WHERE user = '".$result['user_name']."'");
  
    $db->query("DELETE FROM db_serfing WHERE id = '".$id."'");
    $db->query("DELETE FROM db_serfing_view WHERE ident = '".$id."'");
  }  
} 
?>
<script>
 
function getHTTPRequest()
{
    var req = false;
    try {
        req = new XMLHttpRequest();
    } catch(err) {
        try {
            req = new ActiveXObject("MsXML2.XMLHTTP");
        } catch(err) {
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(err) {
                req = false;
            }
        }
    }
    return req;
}

jQuery(document).ready(function(){
    $(".normalm").click(function(e){
        var oLeft = 0, oTop = 0;
        element = this;
        if (element.className == 'normalm') {
            do {
                oLeft += element.offsetLeft;
                oTop  += element.offsetTop;
            } while (element = element.offsetParent);
            var sx = e.pageX - oLeft;
            var sy = e.pageY - oTop;
            var elid = $(this).attr("id");
            fixed(elid, sx, sy);
        }
    }); 
})                

function goserf(obj)
{
    obj.parentNode.innerHTML = "<span class='textgreen'>Спасибо за визит</span>";
    return false;
}

function fixed(p1, p2, p3)
{
    var myReq = getHTTPRequest();
    var params = "p1="+p1+"&p2="+p2+"&p3="+p3;
    function setstate()
    {
        if ((myReq.readyState == 4)&&(myReq.status == 200)) {
            var resvalue = myReq.responseText;
            if (resvalue != '') {
                if (resvalue.length > 12) {
                    if (elem = document.getElementById(p1)) {
                        elem.style.backgroundImage = 'none';
                        elem.className = 'goadvsite';
                        elem.innerHTML = '<div><a target="_blank" href="/'+resvalue+'" onclick="javascript:goserf(this);">Просмотреть сайт рекламодателя</a></div>';
                    }
                } else {
                    if (elem = document.getElementById(resvalue)) {
                        $(elem).fadeOut('low', function() {
                            elem.innerHTML = "<td colspan='3'></td>";
                        });
                    }
                }
            }
        }
    }
    myReq.open("POST", "/ajax/us-fixedserf.php", true);
    myReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    myReq.setRequestHeader("Content-lenght", params.length);
    myReq.setRequestHeader("Connection", "close");
    myReq.onreadystatechange = setstate;
    myReq.send(params);
    return false;
}
</script>


<div class="text_right">


    <link rel="stylesheet" href="/style/main.css" type="text/css" />
    <div class="s-bk-lf">
        <div class="acc-title9">Серфинг</div>
    </div>
    <div class="silver-bk">
     <p style="text-align: center;">Зарабатывай, просматривая сайты рекламодателей</p>
        <center><a href="/account/serfing/add" class="button-green-big button-green-big-new" style="margin-top:10px;">Разместить ссылку</a>&nbsp;<a href="/account/serfing/cabinet" class="button-green-big button-green-big-new" style="margin-top:10px;">Мои ссылки</a></center>
     <table class="work-serf">
      <?php
      $db->query("SELECT ident, time_add FROM db_serfing_view WHERE user_id = '".$_SESSION['user_id']."' and time_add + INTERVAL 24*60*60 SECOND > NOW()");

      while ($row_view = $db->FetchArray())
      {
        $visits[$row_view['ident']] = $row_view;
      }

      $db->Query("SELECT * FROM db_serfing WHERE money >= price and status = '2' ORDER BY high DESC, time_add DESC");

      if ($db->NumRows())
      {
        while ($row = $db->FetchArray())
        {
          if (isset($visits[$row['id']])) continue;

          if ($row['speed'] > 1)
          {
            if (mt_rand(1, $row['speed']) != 1) continue;
          }

          $high = ($row['high']) ? 'serfimghigh' : 'serfimg';


          $pay_user = number_format($row['price'] - (($row['price'] * $data_c['percent_serfing']) / 100), 2);//оплата пользователю


          if ($row['country'])
          {
              $country = explode('|', $row['country']);

              if ($row['crev'])
              {
                if (in_array($_SESSION['country'], $country)) continue; //показывать всем кроме указаных
              }
              else
              {
                if (!in_array($_SESSION['country'], $country)) continue; //показывать только указаным
              }
          }

          if ($row['rating'])
          {
            if ($row['rating'] == 1 && $users_info['insert_sum'] > 10)
            {
              continue;
            }

            if ($row['rating'] == 2 && ($users_info['insert_sum'] < 10 && $users_info['insert_sum'] > 100))
            {
              continue;
            }

            if ($row['rating'] == 3 && ($users_info['insert_sum'] < 100 && $users_info['insert_sum'] > 500))
            {
              continue;
            }

            if ($row['rating'] == 4 && ($users_info['insert_sum'] < 500 && $users_info['insert_sum'] > 1000))
            {
              continue;
            }

            if ($row['rating'] == 5 && $users_info['insert_sum'] < 1000)
            {
              continue;
            }
          }
          ?>
          <tr id="tr<?php echo $row['id']; ?>">
           <td class="normal" width="40" valign="top">
            <span id="adstatus<?php echo $row['id']; ?>" class="<?php echo $high; ?>" title="Реклама: <?php echo $row['id']; ?>, Рекламодатель: <?php echo $row['user_name']; ?> | <?php echo $row['url']; ?>"></span>
           </td>
           <td id="<?php echo $row['id']; ?>" class="normalm" valign="top">
            <?php echo $row['title']; ?><br /><span class="desctext"><?php echo $row['desc']; ?></span>
           </td>
           <td class="normal" nowrap="nowrap" valign="top" style="width: 60px; text-align: right; padding-right: 10px;">
            <span class="smoolgray" title="Осталось визитов">(<?php echo (int)($row['money']/$row['price']); ?>)</span>&nbsp;<span class="clickprice"><?php echo $pay_user; ?>&nbsp;монет</span><br />
            <?php if (isset($_SESSION['admin'])) { ?><a class="workcomp" href="/account/serfing/delete/<?php echo $row['id']; ?>" title="Удалить ссылку и вернуть деньги"></a><?php } ?>
            <!--a class="workevents" href="/account/wall/<?php echo $row['user_name']; ?>" title="Рекламодатель" target="_blank"></a-->
            <!--<a class="workvir" href="http://online.us.drweb.com/result/?url=<?php// echo $row['url']; ?>" title="Проверить ссылку на вирусы" target="_blank"></a>-->
           </td>
          </tr>
          <?php
        }
      }
      else
      {

      }
      ?>
     </table>

    </div>

</div>
 	