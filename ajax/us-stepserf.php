<?php
define('TIME', time());
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);

header("Content-type: text/html; charset=utf-8");

session_start();

function get_codek_ckick($dek)
 {
   $codek[1] = array(1 => '2',
	                   2 => '6',
		                 3 => '3',
		                 4 => '4',
		                 5 => '5',
	                   6 => '1',
		                 7 => '7',                    
		                 8 => '8'	    				 
		    );
   
   $codek[2] = array(1 => '3',
	                   2 => '2',
		                 3 => '8',
		                 4 => '4',
		                 5 => '5',
	                   6 => '7',
		                 7 => '6',                    
		                 8 => '1'	    				 
		    );
   
   $codek[3] = array(1 => '8',
	                   2 => '2',
		                 3 => '4',
		                 4 => '7',
		                 5 => '5',
	                   6 => '6',
		                 7 => '3',                    
		                 8 => '1'	    				 
		    );
   
   if (isset($codek[$dek])) return $codek[$dek];
   
   return false;
 }

if (!isset($_SESSION['user_id'])) { exit('0'); }

if (isset($_POST['cnt']) && isset($_POST['num']) && isset($_SESSION['view']) && $_POST['cnt'] == $_SESSION['view']['cnt'])
{
  $num = (int)$_POST['num']; 
 
  if ($num)
  { 
    if (TIME - $_SESSION['view']['timestart'] < $_SESSION['view']['timer']) exit('0');
   
    $codek = get_codek_ckick($_SESSION['view']['codek_click']);
       
    foreach ($codek as $k => $v)
    {
      if ($v == $num)
      {
        $num = $k;
        break;
      } 
    } 
    
    if ($num == $_SESSION['view']['captcha'])
    {    
      function __autoload($name){ include(BASE_DIR."/classes/_class.".$name.".php");}

      $config = new config;

      $db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
      $db->Query("set names cp1251;");

        $db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
        $config_site = $db->FetchArray();
     
      $db->query("SELECT * FROM  db_serfing WHERE id = '".$_SESSION['view']['id']."' and money >= price LIMIT 1"); 
   
      if ($db->NumRows()) 
      {  
        $result = $db->FetchArray();
        
        $db->query("SELECT id FROM db_serfing_view WHERE ident = '".$_SESSION['view']['id']."' and user_id = '".$_SESSION['user_id']."' and time_add + INTERVAL 24*60*60 SECOND > NOW() LIMIT 1");
 
        if ($db->NumRows()) exit('<div class="blockerror">ERROR!<br /><span>Not link 24 hours</span></div>');
                 
        $move = ($result['move'] == 1) ? $result['url'] : 0;
                
        $id = $result['id'];
        
        if ($id != $_SESSION['view']['id']) exit('<div class="blockerror">ERROR!!!</div>');
        
        $price = $result['price'];        
             
        //$pay_user = number_format($price - ($price*(10/100)), 2); //оплата пользователю

        $pay_user = number_format($price - (($price * $config_site['percent_serfing']) / 100), 2); // Вычитаем у пользователя проценты
        $pay_user_b = number_format($pay_user - (($pay_user * 30) / 100), 2); // оплата пользователю на баланс для покупок
        $pay_user_p = $pay_user - $pay_user_b; // оплата пользователю на баланс для вывода
        $pay_user_ref = $pay_user * 0.1; // оплата рефереру

        //зачисление денег за просмотр пользователю
        $db->query("UPDATE db_users_b SET `money_b` = `money_b` + '".$pay_user_b."', `money_p` = `money_p` + '".$pay_user_p."'	WHERE id = '".$_SESSION['user_id']."'");

        //зачисление денег за просмотр рефереру
        $db->Query("SELECT referer_id FROM db_users_a WHERE id = '".$_SESSION['user_id']."'");
        $user_info = $db->FetchArray();
        $db->query("UPDATE db_users_b SET `money_b` = `money_b` + '".$pay_user_ref."'	WHERE id = '".$user_info['referer_id']."'");
          
        //записываем просмотр списываем бабло
        $db->query("UPDATE db_serfing SET `view` = `view` + '1', `money` = `money` - '".$price."'	WHERE id = '".$id."'");
             
        
        //записываем что просмотрена ссылка
        $db->query("SELECT id, ident FROM db_serfing_view WHERE user_id = '".$_SESSION['user_id']."' and ident = '".$id."' LIMIT 1");
 
        if ($db->NumRows())
        { 
          $result_view = $db->FetchArray();
         
          $db->query("UPDATE db_serfing_view SET time_add = NOW() WHERE id = '".$result_view['id']."'");        
        }
        else
        {
          $db->query("INSERT INTO db_serfing_view (`ident`, `time_add`, `user_id`) VALUES ('".$id."', NOW(), '".$_SESSION['user_id']."')");                                  
        }
                              
        unset($_SESSION['view']);               
        
        exit('OK;'.$pay_user.';'.$move.'');
      }
      else
      {
        exit(0);
      } 
    }
    else
    {
      exit('<div class="blockerror">ERROR!<br /><span>Neverno reshena zadachka</span></div>');
    } 
  }
  else if ($num == 0)
  { 
    $codek_new = rand(1, 3);		
	
    $_SESSION['view']['codek_click'] = $codek_new;
    
    $codek = get_codek_ckick($codek_new);	
    
    $rand = rand(1000000, 9999999);
    ?>
    <table class="clocktable">
     <tr>
      <td><img src="/captcha/captcha-st/captcha.php?sid=<?php echo $rand; ?>" alt="Проверка" style="margin: 0 10px 0 0;" /></td>
      <td nowrap="nowrap">
       <?php             
       for($n = 1; $n<=8; $n++)
       {
         if ($n == 5) echo '<br />';
         ?>
         <span class="serfnum" onclick="vernum(<?php echo $codek[$n] ?>);"><?php echo $n; ?></span>
         <?php         
       } 
       ?>     
      </td>      
     </tr>
    </table>
    <?php
  }
  else
  {
    exit('0'); 
  }
}
else
{
  exit('0'); 
}
?>