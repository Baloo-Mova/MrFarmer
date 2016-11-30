<div class="text_left">	
<a class="left_logo" href="/"></a>
<div class="account_menu">
<?PHP

if(isset($_SESSION["user"]) OR isset($_SESSION["admin"])){
if(isset($_SESSION["admin"]) AND isset($_GET["menu"]) AND $_GET["menu"] == "helpmyadmin"){
		include("inc/_admin_menu.php");
}elseif(isset($_SESSION["user"])){ 
		include("inc/_user_menu.php");
		include("inc/balans.php");
	}
}
?>
<?php if (isset($_GET['menu'])) include("inc/_left_menu.php"); ?>
</div>
</div>