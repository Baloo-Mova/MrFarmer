<?PHP
$_OPTIMIZATION["title"] = "�������";
$_OPTIMIZATION["description"] = "������� ������������";
$_OPTIMIZATION["keywords"] = "�������, ������ �������, ������������";

# ���������� ������
if(!isset($_SESSION["user_id"])){ Header("Location: /"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // �������� ������
		case "stats": include("pages/account/_story.php"); break; // ����������
		case "knb": include("pages/account/_knb.php"); break; // ����������
		case "referals": include("pages/account/_referals.php"); break; // ��������
	
           case "bonus2": include("pages/account/_bonus2.php"); break; // ����� � ������
	case "shop": include("pages/account/_shop.php"); break; // ��� �����
		case "payment": include("pages/account/_payment.php"); break; // ����������
           case "farm": include("pages/account/_farm.php"); break; // �����
          case "bux4ik": include("pages/account/_bux4ik.php"); break; // ������� �����
          case "gono4ki": include("pages/account/_gono4ki.php"); break; // ����� �����
          case "exchange": include("pages/account/_exchange.php"); break; // �������� �����
		case "market": include("pages/account/_market.php"); break; // �����
		case "polezno": include("pages/_polezno.php"); break; // ��������
		case "withdraw": include("pages/account/_withdraw.php"); break; // ������� WM
		case "balance": include("pages/account/_balance.php"); break; // ���������� �������
		case "config": include("pages/account/_config.php"); break; // ���������
          case "rul": include("pages/account/_rul.php"); break; // ������� �����
           case "wheel": include("pages/account/_wheel.php"); break; // ������ �������
		case "bonus": include("pages/account/_bonus.php"); break; // ���������� �����
		case "insert": include("pages/account/_insert.php"); break; // ���������� �������
		case "chat": include("pages/account/_chat.php"); break;
		case "exit": include("exit.php"); break; // �����

        case "advpayeer": include("pages/account/_advpayeer.php"); break; // ���������� �������


        case "serfing": include("pages/account/_serfing.php"); break;
        case "serfing_add": include("pages/account/_serfing_add.php"); break;
        case "serfing_cabinet": include("pages/account/_serfing_cabinet.php"); break;
				
	# �������� ������
	default: @include("pages/_404.php"); break;
			
	}
			
}else @include("pages/account/_user_account.php");

?>