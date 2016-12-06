<?php
/*
 * Серфинг для фермы
 * Версия: 1.00
 * SKYPE: sereega393
 * Использование без оплаты ЗАПРЕЩЕНО!!!
*/
define('TIME', time());

header("Content-Type: text/html; charset=windows-1251");

$msg = '';
$_SESSION['cnt'] = md5($_SESSION['user_id'].session_id());

$db->Query("SELECT * FROM db_users_b WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchArray();

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

 var  defsummin = 1;
            function advevent(badv, buse) 
            {
                var postc = '<?php echo $_SESSION['cnt']; ?>';
                var issend = true;
                if (buse == 3) issend = confirm("Обнулить счётчик просмотров ссылки №" + badv + "?");
                if (buse == 4) issend = confirm("Вы уверены что хотите удалить ссылку №" + badv + "?");
                if (issend)
                    senddata(badv, buse, postc, 1);
                return true;
            }
         
 
 function senddata(radv, ruse, rpostc, rmode)
{
    var myReq = getHTTPRequest();
    var params = "use="+ruse+"&mode="+rmode+"&adv="+radv+"&cnt="+rpostc;
    function setstate()
    {
        console.log(myReq.readyState+ " "+myReq.status);
        if ((myReq.readyState == 4)&&(myReq.status == 200)) {
            var resvalue = parseInt(myReq.responseText);
            if (resvalue > 0) {
                if (ruse == 1) {
                    document.getElementById("advimg"+radv).innerHTML = "<span class='serfcontrol-pause' title='Остановить показ рекламной площадки' onclick='javascript:advevent(" + radv + ",2);'></span>";
                } else
                if (ruse == 2) {
                    document.getElementById("advimg"+radv).innerHTML = "<span class='serfcontrol-play' title='Запустить показ рекламной площадки' onclick='javascript:advevent(" + radv + ",1);'></span>";
                } else
                if (ruse == 3) {
                    document.getElementById("erase"+radv).innerHTML = "0";
                } else
                if (ruse == 4) {
                    $('#adv'+radv).fadeOut('def');
                } else
                if (ruse == 5) {
                    if ((resvalue > 0)&&(resvalue < 8))
                        document.getElementById("int"+radv).className = 'scon-speed-'+resvalue;
                } else
                if (ruse == 6) {
                    document.getElementById("status"+radv).innerHTML = "<span class='desctext' style='text-decoration: blink;'>Ожидает<br />проверки</span>";
                    document.getElementById("advimg"+radv).innerHTML = "<span class='serfcontrol-postmoder'></span>";
                } else
                if (ruse == 7) {
                    window.location.reload(true);
                }
            }
        }
    }
    myReq.open("POST", "/ajax/us-advservice.php", true);
    myReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    myReq.setRequestHeader("Content-lenght", params.length);
    myReq.setRequestHeader("Connection", "close");
    myReq.onreadystatechange = setstate;
    myReq.send(params);
    return false;
}

function submitform(formnum)
{
    if (document.forms['payform'+formnum].pay_order) {
        var field = document.forms['payform'+formnum].pay_order.value;
        var minsum = $('#minsum'+formnum).text();      
        var tm;
        function hidemsg()
        {
            $('#entermsg'+formnum).fadeOut('slow');
            if (tm)
                clearTimeout(tm);
        }
        field = field.replace(",", ".");
        if (field == '') {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>Введите необходимую сумму</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        rprice = parseFloat(field);
        if (isNaN(rprice)) {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>Значение должно быть числовым</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        if (rprice != field) {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>Значение должно быть числовым</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        if (rprice < minsum) {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>Сумма должна быть не менее "+minsum+" баксов</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        var rnote = document.forms['payform'+formnum].pay_adv.value;
        var rart = document.forms['payform'+formnum].pay_mode.value;
        var rcnt = document.forms['payform'+formnum].pay_cnt.value;
        senddatacart(rnote, rart, rprice, rcnt);
        return true;
    }
    return false;
}

function senddatacart(rnote, rart, rprice, rcnt)
{
    var myReq = getHTTPRequest();
    var params = "adv="+rnote+"&use="+rart+"&price="+rprice+"&cnt="+rcnt;
    function setstate()
    {
        if ((myReq.readyState == 4)&&(myReq.status == 200)) {
            var resvalue = myReq.responseText;
            if (resvalue != '') {
                if (resvalue > 0) {                   
                    document.getElementById("entermsg"+rnote).innerHTML = "<center>Оплачено</center>";
                    window.location.reload(true);
                } else
                    document.getElementById("entermsg"+rnote).innerHTML = "<span class='msgbox-error'>"+resvalue+"</span>";
            } else {
                document.getElementById("entermsg"+rnote).innerHTML = "<span class='msgbox-error'>Не удалось обработать запрос</span>";
            }
        } else {
            document.getElementById("entermsg"+rnote).innerHTML = "<span class='loading' title='Подождите пожалуйста...'></span>";
            document.getElementById("entermsg"+rnote).style.display = '';
        }
    }
    myReq.open("POST", "/ajax/us-advservice.php", true);
    myReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    myReq.setRequestHeader("Content-lenght", params.length);
    myReq.setRequestHeader("Connection", "close");
    myReq.onreadystatechange = setstate;
    myReq.send(params);
    return false;
}

function hideserfaddblock(bname) {
    if (document.getElementById(bname).style.display == 'none')
        document.getElementById(bname).style.display = '';
    else
        document.getElementById(bname).style.display = 'none';
    return false;
}
function alertbudget()
{
    alert("Пополните рекламный бюджет");
    return false;
}
function alertnochange()
{
    alert("Задание можно редактировать только раз в 3 часа");
    return false;
}

function reportformactivate(dnum, dmode) {
    if (dmode == 2)
        document.getElementById('delcomment'+dnum).style.display = '';
    else
    if (dmode == 3)
        document.getElementById('reversecomment'+dnum).style.display = '';
    document.getElementById('btns'+dnum).style.display = 'none';
    return false;
    }
</script>

<div class="text_right">

<link rel="stylesheet" href="/style/main.css" type="text/css" />
<div class="s-bk-lf">
	<div class="acc-title9">Мои ссылки</div>
</div>
<div class="silver-bk">
 <?php
 $db->Query("SELECT * FROM db_serfing WHERE user_name = '".$_SESSION['user']."' ORDER BY time_add DESC");
  
 if ($db->NumRows())
 {  
   while ($row = $db->FetchArray())
   {
     ?>
     <table class="adv-serf">
      <tbody>
       <tr id="adv<?php echo $row['id']; ?>">
        <td>
         <div id="advimg<?php echo $row['id']; ?>">
          <?php   
          if ($row['status'] == 0)
          {
            ?><span class="serfcontrol-moder"></span><?php
          } 
          else if ($row['status'] == 1)
          {
            ?><span class="serfcontrol-postmoder"></span><?php
          }
          else if ($row['status'] == 2)
          {
            ?><span class="serfcontrol-pause" title="Остановить показ ссылки" onclick="javascript:advevent(<?php echo $row['id']; ?>,2);"></span><?php
          }
          else if ($row['status'] == 3)
          {
            if ($row['money'] >= $row['price'])
            {
              ?><span class="serfcontrol-play" title="Запустить показ ссылки" onclick="javascript:advevent(<?php echo $row['id']; ?>,1);"></span><?php
            }
            else
            {
              ?><span class="serfcontrol-play" title="Запустить показ ссылки" onclick="javascript:alertbudget();"></span><?php
            }           
          } 
          ?>
          
         </div>
        </td>
        <td width="80%">
         <a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['title']; ?><br>
          <span class="desctext"><?php echo $row['desc']; ?></span></a><br>
         <span class="serfinfotext">№ <?php echo $row['id']; ?>&nbsp;&nbsp;Клик: <?php echo $row['price']; ?> баксов.&nbsp;&nbsp;Просмотров: 
         <div style="display: inline;" id="erase<?php echo $row['id']; ?>"><?php echo $row['view']; ?></div>
         
         </span>
          <?php
          if ($row['money'] == 0)
          { 
            ?><span class="scon-delete" title="Удалить ссылку" onclick="javascript:advevent(<?php echo $row['id']; ?>,4);"></span><?php
          }
          ?>
          <a class="scon-edit" href="/account/serfing/edit/<?php echo $row['id']; ?>" title="Редактировать ссылку"></a>
        </td>
        <td class="budget">
         <?php
         if ($row['status'] == 0)
         {
           ?><div id="status<?php echo $row['id']; ?>"><span class="transport-moder" title="Отправить рекламу на проверку арбитрам" onclick="javascript:advevent(<?php echo $row['id']; ?>,6);">Отправить<br />на проверку</span></div><?php                                                                                   
         }
         else if ($row['status'] == 1)
         {
           ?><span class="desctext" style="text-decoration: blink">Ожидает<br />проверки</span><?php
         }        
         else
         {
           if ($row['money'] > 0)
           {
             ?><span class="add-budget" title="Пополнить рекламный бюджет" onclick="javascript:hideserfaddblock('serfadd<?php echo $row['id']; ?>');"><span style="font-size: 11px"><?php echo $row['money']; ?></span></span><?php
           }
           else
           { 
             ?><span class="add-budgetnone" title="Пополнить рекламный бюджет" onclick="javascript:hideserfaddblock('serfadd<?php echo $row['id']; ?>');"><span style="font-size: 11px">Пополнить</span></span><?php
           }
         }        
         ?>
         
        </td>      
       </tr>
       <tr id="serfadd<?php echo $row['id']; ?>" style="display: none">
        <td class="ext" colspan="3">
         <form name="payform<?php echo $row['id']; ?>" class="pay-form" onkeypress="if (event.keyCode == 13) return false;">
          <input name="pay_cnt" value="<?php echo $_SESSION['cnt']; ?>" type="hidden">
          <input name="pay_mode" value="12" type="hidden">
          <input name="pay_user" value="<?php echo $_SESSION['user_id']; ?>" type="hidden">
          <input name="pay_adv" value="<?php echo $row['id']; ?>" type="hidden">Укажите сумму, которую вы хотите внести в бюджет рекламной площадки<br>(Минимум <span id="minsum<?php echo $row['id']; ?>"><?php echo $row['price']; ?></span> баксов)<input name="pay_order" maxlength="10" value="<?php echo number_format($row['price']*1000, 2, '.', ''); ?>" type="text"><center><span class="button-red" title="Внести средства в бюджет площадки" onclick="javascript:submitform(<?php echo $row['id']; ?>);">Оплатить</span></center></form>
         <div id="entermsg<?php echo $row['id']; ?>" style="display: none"></div>
        </td>
       </tr>
      </tbody>
     </table>
 
     <?php
   }
 } 
 else
 {
   echo 'ссылок нет';
 }
 
 ?>
 <center>
 <a href="/account/serfing/add" class="button-green-big" style="margin-top:10px">Разместить ссылку</a>
</center>
</div>

</div>
 	