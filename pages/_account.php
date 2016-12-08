<?PHP
$_OPTIMIZATION["title"] = "Аккаунт";
$_OPTIMIZATION["description"] = "Аккаунт пользователя";
$_OPTIMIZATION["keywords"] = "Аккаунт, личный кабинет, пользователь";

# Блокировка сессии
if(!isset($_SESSION["user_id"])){ Header("Location: /"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // Страница ошибки
		case "stats": include("pages/account/_story.php"); break; // Статистика
		case "knb": include("pages/account/_knb.php"); break; // Статистика
		case "referals": include("pages/account/_referals.php"); break; // Рефералы
	
           case "bonus2": include("pages/account/_bonus2.php"); break; // Бонус с риском
	case "shop": include("pages/account/_shop.php"); break; // Моя ферма
		case "payment": include("pages/account/_payment.php"); break; // Статистика
           case "farm": include("pages/account/_farm.php"); break; // Склад
          case "bux4ik": include("pages/account/_bux4ik.php"); break; // Коробка удачи
          case "gono4ki": include("pages/account/_gono4ki.php"); break; // Гонки машин
          case "exchange": include("pages/account/_exchange.php"); break; // Обменный пункт
		case "market": include("pages/account/_market.php"); break; // Рынок
		case "polezno": include("pages/_polezno.php"); break; // Полезное
		case "withdraw": include("pages/account/_withdraw.php"); break; // Выплата WM
		case "balance": include("pages/account/_balance.php"); break; // Пополнение баланса
		case "config": include("pages/account/_config.php"); break; // Настройки
          case "rul": include("pages/account/_rul.php"); break; // Коробка удачи
           case "wheel": include("pages/account/_wheel.php"); break; // Колесо фортуны
		case "bonus": include("pages/account/_bonus.php"); break; // Ежедневный бонус
		case "insert": include("pages/account/_insert.php"); break; // Пополнение баланса
		case "chat": include("pages/account/_chat.php"); break;
		case "exit": include("exit.php"); break; // Выход

        case "advpayeer": include("pages/account/_advpayeer.php"); break; // Пополнение баланса


        case "serfing": include("pages/account/_serfing.php"); break;
        case "serfing_add": include("pages/account/_serfing_add.php"); break;
        case "serfing_cabinet": include("pages/account/_serfing_cabinet.php"); break;
				
	# Страница ошибки
	default: @include("pages/_404.php"); break;
			
	}
			
}else @include("pages/account/_user_account.php");

?>