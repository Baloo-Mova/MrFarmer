<?php
/*
 * —ерфинг дл€ фермы
 * ¬ерси€: 1.00
 * SKYPE: sereega393
*/
define('TIME', time());
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);

header("Content-type: text/html; charset=utf-8");

session_start();

if (!isset($_SESSION['user_id'])) { exit(); }

function __autoload($name){ include(BASE_DIR."/classes/_class.".$name.".php");}

$config = new config;

$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$db->Query("set names cp1251;");

$db->Query("SELECT * FROM db_users_b WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchArray();

//return ($_POST); exit();

if (isset($_POST['cnt']) && $_POST['cnt'] == $_SESSION['cnt'])
{
  $user_name = $_SESSION['user'];
  $adv = isset($_POST['adv']) ? (int) $_POST['adv'] : 0; 
  $mode = isset($_POST['mode']) ? (int) $_POST['mode'] : 0; 
  $use = isset($_POST['use']) ? (int) $_POST['use'] : 0;
    
  if (!$adv && !$mode && !$use) exit('no1');
  
  if (isset($_SESSION['admin']))
  {
    $db->query("SELECT * FROM db_serfing WHERE id = '".$adv."'"); 
  } 
  else
  { 
    $db->query("SELECT * FROM db_serfing WHERE user_name = '".$user_name."' and id = '".$adv."'"); 
  }  
  
  if (!$db->NumRows()) exit('no2');
  
  $result = $db->FetchArray();


  
  switch ($use)
  {
    //запуск
    case 1:
    
    if ($result['status'] == 3 && $result['money'] >= $result['price']) 
    {     
      $db->query("UPDATE db_serfing SET status = '2' WHERE id = '".$adv."'");       
        
      exit('1');
    }  
    
    break;
    
    //пауза
    case 2:
    
    if ($result['status'] == 2) 
    {      
      $db->query("UPDATE db_serfing SET status = '3' WHERE id = '".$adv."'");       
        
      exit('1');
    }  
    
    break;
   
    //очистка просмотров
    case 3:
    
    if ($result['view'] > 0) 
    { 
      $db->query("UPDATE db_serfing SET view = '0' WHERE id = '".$adv."'");       
        
      exit('1');   
    }  
    
    break;
    
    //удаление
    case 4:
    
    if ($result['money'] > 0) exit('no3'); 
    
    if ($mode == 2) exit();
    
    $db->query("DELETE FROM db_serfing WHERE id = '".$adv."'");       
     
    $db->query("DELETE FROM db_serfing_view WHERE ident = '".$adv."'"); 
    
    exit('1');
    
    break;
  
    //скорость просмотров
    case 5:

    $speed = ($result['speed'] + 1) <= 7 ? $result['speed'] + 1 : 1; 
      
    $db->query("UPDATE db_serfing SET speed = '".$speed."' WHERE id = '".$adv."'");       
        
    exit(''.$speed.'');     
    
    break;
    
    //отправка на модерацию
    case 6:

    if ($result['status'] == 0)  
    {  
      $db->query("UPDATE db_serfing SET status = '1' WHERE id = '".$adv."'");        
   
      exit('1'); 
    }     
      
    break;
    
    //одобрение модером
    case 10:

    if ($result['status'] == 1)
    {  
      $db->query("UPDATE db_serfing SET status = '3' WHERE id = '".$adv."'");        
   
      exit('1'); 
    }     
      
    break;
    
    //удаление модером
    case 11:

    $db->query("DELETE FROM db_serfing WHERE id = '".$adv."'");
    $db->query("DELETE FROM db_serfing_view WHERE ident = '".$adv."'"); 
     
    exit('1'); 
              
    break;
   
    //пополнение баланса
    case 12:

    $money = floatval($_POST['price']); 
    
    if ($money <= 0) exit('YOU BAD CHEL )))'); 
     
    if (isset($_SESSION['admin']))
    { 
      $db->query("UPDATE db_serfing SET `money` = `money` + '".$money."' WHERE id = '".$adv."'"); 
      
      exit('1');
    } 
    else
    {

      if($_POST['pay_type'] == 1){ // —писать со счета дл€ вывода
          if ($users_info['money_p'] >= $money)
          {

              $db->query("UPDATE db_serfing SET `money` = `money` + '".$money."' WHERE id = '".$adv."'");

              $db->query("UPDATE db_users_b SET `money_p` = `money_p` - '".$money."'	WHERE id = '".$_SESSION['user_id']."'");

              exit('1');
          }
          else
          {
              exit('NO MONEY');
          }
      }
      if($_POST['pay_type'] == 2){ // —писать со счета дл€ покупок
          if ($users_info['money_b'] >= $money)
          {

              $db->query("UPDATE db_serfing SET `money` = `money` + '".$money."' WHERE id = '".$adv."'");

              $db->query("UPDATE db_users_b SET `money_b` = `money_b` - '".$money."'	WHERE id = '".$_SESSION['user_id']."'");

              exit('1');
          }
          else
          {
              exit('NO MONEY');
          }
      }


    } 
              
    break;

    default:
    break;
  }
}  

exit('no4');
?>