<?php 
define('TIME', time());
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
session_start();
if (!isset($_SESSION['user_id'])) { exit(); }

function __autoload($name){ include(BASE_DIR."/classes/_class.".$name.".php");}

$config = new config;

$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$db->Query("set names cp1251;");

$id = (int)$_GET['view']; 

$db->query("SELECT * FROM db_serfing WHERE id = '".$id."' and money >= price and status = '2' LIMIT 1"); 
   
if ($db->NumRows()) 
{ 
  $result = $db->FetchArray();
  
  $_SESSION['view']['cnt'] = md5(session_id().$_SESSION['user_id'].$result['id']);
  $_SESSION['view']['id'] = $result['id'];
  $_SESSION['view']['timer'] = $result['timer'];
  $_SESSION['view']['timestart'] = TIME;
  
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <title>Просмотр сайтов</title>
    <meta name="robots" content="none" />
   </head>
   <frameset onLoad="javascript: frame_footer.startClock();" rows="*,70" style="border: none;">
    <frame name="frame_site" src="<?php echo $result['url']; ?>" marginwidth="0" marginheight="0" frameborder="0" />
    <frame name="frame_footer" src="/serf-fblock.php?cnt=<?php echo $_SESSION['view']['cnt']; ?>" marginwidth="0" marginheight="0" scrolling="no" noresize="noresize" frameborder="0" />
   </frameset>
  </html>
  <?php
}
else
{
  exit('Не существует или закончились просмотры');
} 
?>

