<?php 
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_data = $db->FetchArray();


?>


<a href="/account/withdraw.html" class="your_gold">
	<div>��� ������ <?=floor($user_data['money_b']);?> ����� ��� ������� </div>
	<div class="clear"></div>
	---------------------------------
	<div class="clear"></div>
	<span><div id="resources_GOD"><?=floor($user_data['money_p']);?> ����� ��� ������</div></span>
</a>