<?php 
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_data = $db->FetchArray();

if(strpos($_SERVER['HTTP_REFERER'], "serfing") == false){
	$myclass = "";
}else{
	$myclass = "hidden";
}
?>


<a href="/account/withdraw.html" class="your_gold <?php echo $myclass; ?>">
	<div>Ваш баланс <?=floor($user_data['money_b']);?> монет для покупок </div>
	<div class="clear"></div>
	---------------------------------
	<div class="clear"></div>
	<span><div id="resources_GOD"><?=floor($user_data['money_p']);?> монет для вывода</div></span>
</a>