<?php
define('TIME', time());
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
session_start();
if (!isset($_SESSION['user_id'])) { exit(); }

if (isset($_GET['cnt']) && isset($_SESSION['view']['id']) && isset($_SESSION['view']['timer']) && $_GET['cnt'] == $_SESSION['view']['cnt'])
{
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
   <link rel="stylesheet" href="/style/style-serf.css" type="text/css" />
   <script type="text/javascript" src="/js/serfing.js"></script>
   <script type="text/javascript" language="JavaScript">
       var vtime = stattime = <?php echo $_SESSION['view']['timer']; ?>;
       var cnt = '<?php echo $_SESSION['view']['cnt']; ?>';
   </script>
  </head>
  <body>
   <table class="serfframe" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td>
      <div id="blockverify">
       <div id="blockwait">
        Подождите, сайт загружается...
       </div>
       <div id="blocktimer" style="display: none;">
        <form class="clockalert" name="frm" method="post" action="" onsubmit="return false;">
         <input name="clock" size="3" readonly="readonly" type="text" value=""/>
         <br />
         <span>Дождитесь окончания таймера</span>
        </form>
       </div>
      </div>
     </td>
     <td align="right" class="footer" width="500">
     </td>
    </tr>
   </table>
  </body>
  </html>
  <?php
}
?>