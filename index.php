<?PHP
error_reporting(0); // вывод ошибок




if($_GET['menu']!='admin' && 'support'){
function limpiarez($mensaje){
$mensaje = htmlspecialchars(trim($mensaje));
$mensaje = str_replace("'","&prime;",$mensaje);
$mensaje = str_replace(";","&brvbar;",$mensaje);
$mensaje = str_replace("$"," USD ",$mensaje);
$mensaje = str_replace("<","&lang;",$mensaje);
$mensaje = str_replace(">","&rang;",$mensaje);
$mensaje = str_replace('"',"&rdquo;",$mensaje);
$mensaje = str_replace("%27"," ",$mensaje);
$mensaje = str_replace("0x29"," ",$mensaje);
$mensaje = str_replace("&amp amp ","&",$mensaje);
return $mensaje;
}

foreach($HTTP_POST_VARS as $i => $value){$HTTP_POST_VARS[$i]=limpiarez($HTTP_POST_VARS[$i]);}
foreach($HTTP_GET_VARS as $i => $value){$HTTP_GET_VARS[$i]=limpiarez($HTTP_GET_VARS[$i]);}
foreach($_POST as $i => $value){$_POST[$i]=limpiarez($_POST[$i]);}
foreach($_GET as $i => $value){$_GET[$i]=limpiarez($_GET[$i]);}
foreach($_COOKIE as $i => $value){$_COOKIE[$i]=limpiarez($_COOKIE[$i]);}


foreach($HTTP_POST_VARS as $i => $value){$HTTP_POST_VARS[$i]=stripslashes($HTTP_POST_VARS[$i]);}
foreach($HTTP_GET_VARS as $i => $value){$HTTP_GET_VARS[$i]=stripslashes($HTTP_GET_VARS[$i]);}
foreach($_POST as $i => $value){$_POST[$i]=stripslashes($_POST[$i]);}
foreach($_GET as $i => $value){$_GET[$i]=stripslashes($_GET[$i]);}
foreach($_COOKIE as $i => $value){$_COOKIE[$i]=stripslashes($_COOKIE[$i]);}

################## Фильтрация всех POST и GET #######################################
function filter_sf(&$sf_array) 
{ 
while (list ($X,$D) = each ($sf_array)): 
$sf_array[$X] = limpiarez(mysql_escape_string(strip_tags(htmlspecialchars($D))));
endwhile;
} 
filter_sf($_GET);
filter_sf($_POST); 
#####################################################################################

function anti_sql() 
{
$check = html_entity_decode( urldecode( $_SERVER['REQUEST_URI'] ) );
$check = str_replace( "", "/", $check );

$check = mysql_real_escape_string($str);
$check = trim($str); 
$check = array("AND","UNION","SELECT","WHERE","INSERT","UPDATE","DELETE","OUTFILE","FROM","OR","SHUTDOWN","CHANGE","MODIFY","RENAME","RELOAD","ALTER","GRANT","DROP","CONCAT","cmd","exec");
$check = str_replace($check,"",$str);


if( $check ) 
{
if((strpos($check, '<')!==false) || (strpos($check, '>')!==false) || (strpos($check, '"')!==false) || (strpos($check,"'")!==false) || (strpos($check, '*')!==false) || (strpos($check, '(')!==false) || (strpos($check, ')')!==false) || (strpos($check, ' ')!==false) || (strpos($check, ' ')!==false) || (strpos($check, ' ')!==false) ) 
{
$prover = true;
}

if((strpos($check, 'src')!==false) || (strpos($check, 'img')!==false) || (strpos($check, 'OR')!==false) || (strpos($check, 'Image')!==false) || (strpos($check, 'script')!==false) || (strpos($check, 'javascript')!==false) || (strpos($check, 'language')!==false) || (strpos($check, 'document')!==false) || (strpos($check, 'cookie')!==false) || (strpos($check, 'gif')!==false) || (strpos($check, 'png')!==false) || (strpos($check, 'jpg')!==false) || (strpos($check, 'js')!==false) ) 
{
$prover = true;
}

}

if (isset($prover))
{
die( "Попытка атаки на сайт или введены запрещённые символы!" );
return false;
exit;
}
}
anti_sql();

}
# Счетчик
function TimerSet(){
	list($seconds, $microSeconds) = explode(' ', microtime());
	return $seconds + (float) $microSeconds;
}

$_timer_a = TimerSet();

# Старт сессии
@session_start();

# Старт буфера
@ob_start();

# Default
$_OPTIMIZATION = array();
$_OPTIMIZATION["title"] = "Главная";
$_OPTIMIZATION["description"] = "Mr.Farmer";
$_OPTIMIZATION["keywords"] = "Заработок на животных, вложения, заработать, ферма, денежная ферма, заработать на ферме,инвестиции, серфинг, задания, заработать в интернете";

# Константа для Include
define("CONST_RUFUS", true);

# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}

# Класс конфига 
$config = new config;

# Функции
$func = new func;

# Установка REFERER
include("inc/_set_referer.php");

# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

# Шапка
@include("inc/_header.php");

		if(isset($_GET["menu"])){
		
			$menu = strval($_GET["menu"]);
			
			switch($menu){
			
				case "404": include("pages/_404.php"); break; // Страница ошибки
				case "rules": include("pages/_rules.php"); break; // Правила проекта
				case "about": include("pages/_about.php"); break; // О проекте
				case "contacts": include("pages/_contacts.php"); break; // Контакты
				case "competition": include("pages/_competition.php"); break; // Конкурсы

                     case "news": include("pages/_news.php"); break; // Новости
				case "signup": include("pages/_signup.php"); break; // Регистрация
				case "login": include("pages/_login.php"); break; // Регистрация
				case "recovery": include("pages/_recovery.php"); break; // Восстановление пароля
				case "account": include("pages/_account.php"); break; // Аккаунт
				case "account": include("pages/_polezno.php"); break; // Полезное
				case "users": include("pages/_users_list.php"); break; // Пользователи
				case "payments": include("pages/_payments_list.php"); break; // Выплаты
				case "games": include("pages/_game.php"); break; // Выплаты
				case "otziv": include("pages/_otziv.php"); break; // Выплаты
				case "faq": include("pages/_faq.php"); break; // FAQ
				
				case "chat": include("pages/_chat.php"); break; // Чат
              
				case "helpmyadmin": include("pages/_admin.php"); break; // Админка
				
			# Страница ошибки
			default: @include("pages/_404.php"); break;
			
			}
			
		}else @include("pages/_index.php");


# Подвал
@include("inc/_footer.php");


# Заносим контент в переменную
$content = ob_get_contents();

# Очищаем буфер
ob_end_clean();
	
	# Заменяем данные
	$content = str_replace("{!TITLE!}",$_OPTIMIZATION["title"],$content);
	$content = str_replace('{!DESCRIPTION!}',$_OPTIMIZATION["description"],$content);
	$content = str_replace('{!KEYWORDS!}',$_OPTIMIZATION["keywords"],$content);
	$content = str_replace('{!GEN_PAGE!}', sprintf("%.5f", (TimerSet() - $_timer_a)) ,$content);
	
	# Вывод баланса
	if(isset($_SESSION["user_id"])){
	
		$user_id = $_SESSION["user_id"];
		$db->Query("SELECT money_b, money_p FROM db_users_b WHERE id = '$user_id'");
		$balance = $db->FetchArray();
		
		$content = str_replace('{!BALANCE_B!}', sprintf("%.2f", $balance["money_b"]) ,$content);
		$content = str_replace('{!BALANCE_P!}', sprintf("%.2f", $balance["money_p"]) ,$content);
	}
	
// Выводим контент
echo $content;
?>