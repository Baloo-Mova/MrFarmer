<?php
/*
 * ������� ��� �����
 * ������: 1.00
 * SKYPE: sereega393
 * ������������� ��� ������ ���������!!!
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
                if (buse == 3) issend = confirm("�������� ������� ���������� ������ �" + badv + "?");
                if (buse == 4) issend = confirm("�� ������� ��� ������ ������� ������ �" + badv + "?");
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
                    document.getElementById("advimg"+radv).innerHTML = "<span class='serfcontrol-pause' title='���������� ����� ��������� ��������' onclick='javascript:advevent(" + radv + ",2);'></span>";
                } else
                if (ruse == 2) {
                    document.getElementById("advimg"+radv).innerHTML = "<span class='serfcontrol-play' title='��������� ����� ��������� ��������' onclick='javascript:advevent(" + radv + ",1);'></span>";
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
                    document.getElementById("status"+radv).innerHTML = "<span class='desctext' style='text-decoration: blink;'>�������<br />��������</span>";
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
        var pay_type = $(".payform_select_"+formnum).val();
        function hidemsg()
        {
            $('#entermsg'+formnum).fadeOut('slow');
            if (tm)
                clearTimeout(tm);
        }
        field = field.replace(",", ".");
        if (field == '') {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>������� ����������� �����</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        rprice = parseFloat(field);
        if (isNaN(rprice)) {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>�������� ������ ���� ��������</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        if (rprice != field) {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>�������� ������ ���� ��������</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        if (rprice < minsum) {
            document.getElementById('entermsg'+formnum).innerHTML = "<span class='msgbox-error'>����� ������ ���� �� ����� "+minsum+" ������</span>";
            document.getElementById('entermsg'+formnum).style.display = '';
            tm = setTimeout(function() {
                hidemsg()
            }, 1000);
            return false;
        }
        var rnote = document.forms['payform'+formnum].pay_adv.value;
        var rart = document.forms['payform'+formnum].pay_mode.value;
        var rcnt = document.forms['payform'+formnum].pay_cnt.value;
        senddatacart(rnote, rart, rprice, rcnt, pay_type);
        return true;
    }
    return false;
}

function senddatacart(rnote, rart, rprice, rcnt, pay_type)
{
    var myReq = getHTTPRequest();
    var params = "adv="+rnote+"&use="+rart+"&price="+rprice+"&cnt="+rcnt+"&pay_type="+pay_type;
    function setstate()
    {
        if ((myReq.readyState == 4)&&(myReq.status == 200)) {
            var resvalue = myReq.responseText;
            if (resvalue != '') {
                if (resvalue > 0) {                   
                    document.getElementById("entermsg"+rnote).innerHTML = "<center>��������</center>";
                    window.location.reload(true);
                } else
                    document.getElementById("entermsg"+rnote).innerHTML = "<span class='msgbox-error'>"+resvalue+"</span>";
            } else {
                document.getElementById("entermsg"+rnote).innerHTML = "<span class='msgbox-error'>�� ������� ���������� ������</span>";
            }
        } else {
            document.getElementById("entermsg"+rnote).innerHTML = "<span class='loading' title='��������� ����������...'></span>";
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
    alert("��������� ��������� ������");
    return false;
}
function alertnochange()
{
    alert("������� ����� ������������� ������ ��� � 3 ����");
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


function getpayeerform(type, id, mysum, myid) {
    if(type == 3){
        $(".adv_type_button").css("cssText", "display: none !important;");
        $(".payeer_"+id).html("<form method=\"POST\" action=\"/account/advpayeer.html\">"+
                "<input type=\"hidden\" name=\"method\" value=\"payeer\">"+
                "<input type=\"hidden\" name=\"sum\" value=\""+mysum+"\">"+
                "<input type=\"hidden\" name=\"adv_id\" value=\""+myid+"\">"+
                "<input type=\"submit\" class=\"payeer_submit\" name=\"pay\" value=\"������� � ������ �����\" />"+
            "</form>");
    }else{
        $(".payeer_"+id).html("");
        $(".adv_type_button").css("display", "block");
    }
}

function payselect(id) {
    $(".pay_order_"+id).css("display", "none");
    $(".payform"+id).append("<center><select class=\"payform_select payform_select_"+id+"\" name=\"pay_type\"  " +
        "onchange=\"javascript:getpayeerform(this.options[this.selectedIndex].value, id, document.getElementById('pay_adv_sum_"+id+"').value, "+id+")\">" +
            "<option value=\"1\" selected>���� ��� ������</option>" +
            "<option value=\"2\">���� ��� �������</option>" +
            "<option value=\"3\">Payeer</option>" +
        "</select>" +
        "<span class=\"button-red-new adv_type_button\" title=\"������ �������� � ������ ��������\" onclick=\"javascript:submitform("+id+");\">��������</span>" +
        "");
}



</script>

<div class="text_right">

<link rel="stylesheet" href="/style/main.css" type="text/css" />
<div class="s-bk-lf">
	<div class="acc-title9">��� ������</div>
</div>
<div class="silver-bk">

    <center>
        <a href="/account/serfing/add" class="button-green-big" style="margin-top:10px">���������� ������</a>
    </center>
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
            ?><span class="serfcontrol-pause" title="���������� ����� ������" onclick="javascript:advevent(<?php echo $row['id']; ?>,2);"></span><?php
          }
          else if ($row['status'] == 3)
          {
            if ($row['money'] >= $row['price'])
            {
              ?><span class="serfcontrol-play" title="��������� ����� ������" onclick="javascript:advevent(<?php echo $row['id']; ?>,1);"></span><?php
            }
            else
            {
              ?><span class="serfcontrol-play" title="��������� ����� ������" onclick="javascript:alertbudget();"></span><?php
            }           
          } 
          ?>
          
         </div>
        </td>
        <td width="80%">
         <a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['title']; ?><br>
          <span class="desctext"><?php echo $row['desc']; ?></span></a><br>
         <span class="serfinfotext">� <?php echo $row['id']; ?>&nbsp;&nbsp;����: <?php echo $row['price']; ?> ���. �����.&nbsp;&nbsp;����������:
         <div style="display: inline;" id="erase<?php echo $row['id']; ?>"><?php echo $row['view']; ?></div>
         
         </span>
          <?php
          if ($row['money'] == 0)
          { 
            ?><span class="scon-delete" title="������� ������" onclick="javascript:advevent(<?php echo $row['id']; ?>,4);"></span><?php
          }
          ?>
          <a class="scon-edit" href="/account/serfing/edit/<?php echo $row['id']; ?>" title="������������� ������"></a>
        </td>
        <td class="budget">
         <?php
         if ($row['status'] == 0)
         {
           ?><div id="status<?php echo $row['id']; ?>"><span class="transport-moder" title="��������� ������� �� �������� ��������" onclick="javascript:advevent(<?php echo $row['id']; ?>,6);">���������<br />�� ��������</span></div><?php                                                                                   
         }
         else if ($row['status'] == 1)
         {
           ?><span class="desctext" style="text-decoration: blink">�������<br />��������</span><?php
         }        
         else
         {
           if ($row['money'] > 0)
           {
             ?><span class="add-budget" title="��������� ��������� ������" onclick="javascript:hideserfaddblock('serfadd<?php echo $row['id']; ?>');"><span style="font-size: 11px"><?php echo $row['money']; ?></span></span><?php
           }
           else
           { 
             ?><span class="add-budgetnone" title="��������� ��������� ������" onclick="javascript:hideserfaddblock('serfadd<?php echo $row['id']; ?>');"><span style="font-size: 11px">���������</span></span><?php
           }
         }        
         ?>
         
        </td>      
       </tr>
       <tr id="serfadd<?php echo $row['id']; ?>" style="display: none">
        <td class="ext" colspan="3">
         <form name="payform<?php echo $row['id']; ?>" class="pay-form payform<?php echo $row['id']; ?>" onkeypress="if (event.keyCode == 13) return false;">
          <input name="pay_cnt" value="<?php echo $_SESSION['cnt']; ?>" type="hidden">
          <input name="pay_mode" value="12" type="hidden">
          <input name="pay_user" value="<?php echo $_SESSION['user_id']; ?>" type="hidden">
          <input name="pay_adv" value="<?php echo $row['id']; ?>" type="hidden">������� �����, ������� �� ������ ������ � ������ ��������� ��������<br>(������� <span id="minsum<?php echo $row['id']; ?>"><?php echo ($row['price'] * 10); ?></span> ������)<div class="pay_order_<?php echo $row['id']; ?>"> <input name="pay_order" maxlength="10" id="pay_adv_sum_<?php echo $row['id']; ?>"  value="<?php echo number_format($row['price']*10, 2, '.', ''); ?>" type="text"><center><span class="button-red adv_pay" title="������ �������� � ������ ��������" onclick="javascript:payselect(<?php echo $row['id']; ?>);">��������</span></div><div class="payeer_"<?php echo $row['id']; ?>> </div></center></form>
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
   echo '������ ���';
 }
 
 ?>

</div>

</div>

