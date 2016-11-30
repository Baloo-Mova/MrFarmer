<?PHP
$_OPTIMIZATION["title"] = "Модерирование чата";
$_OPTIMIZATION["description"] = "";
$_OPTIMIZATION["keywords"] = "";
?>
<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">
<div class="s_divide"></div>
<div class="shop">
<div class="block">
<div class="block_name">Чат модерация</div>	



<?php
$res = $db->Query('SELECT `chat_moder` FROM `db_users_a` WHERE `user` = "'.$_SESSION["user"].'"');
$chat_moder = $db->FetchRow();

if($chat_moder != 1){
	$mess[] = "<div style='width: 465px' class='err'>Вы не являетесь модератором проекта!</div>";
}

if($_GET['t'] == 'ban'){
	$res = $db->query('SELECT `time_uban` FROM `db_chat_ban` WHERE `user` = "'.$db->RealEscape($_GET['id']).'" AND `time_uban` > '.time());
	
	if($db->NumRows() == 0){
		if(isset($_POST['ban_sub'])){
			$db->query('DELETE FROM `db_chat_ban` WHERE `user` = "'.$db->RealEscape($_GET['id']).'"');
			$db->query('INSERT INTO `db_chat_ban` (`user`, `time_uban`) VALUES ("'.$db->RealEscape($_GET['id']).'", '.(time() + intval(abs($_POST['time_uban']) * 86400)).')');
			$mess[] = "<div style='width: 465px' class='err'>Пользователь забанен</div>";
		}
	
		echo '<form action="" method="post">Забанить на 
		<input name="time_uban" type="text" value="1" size="5" /> дней. <input name="ban_sub" type="submit" value="Забанить" /></form>';
	}else{
		$db->query('DELETE FROM `db_chat_ban` WHERE `user` = "'.$db->RealEscape($_GET['id']).'"');
		$mess[] = "<div style='width: 465px' class='ok'>Пользователь розбанен</div>";
	}
}

if($_GET['t'] == 'del'){
	$db->query('DELETE FROM `db_chat` WHERE `id` = '.intval($_GET['id']));
	$mess[] = "<div style='width: 465px' class='ok'>Удалено</div>";
}

if($_GET['t'] == 'edit'){
	$res = $db->Query('SELECT `comment` FROM `db_chat` WHERE `id` = '.intval($_GET['id']));
	
	if($db->NumRows() == 0){
		$mess[] = "<div style='width: 465px' class='err'>Сообщение не найдено</div>";
	}
	
	if(isset($_POST['edit_sub'])){
		$_POST['comment'] = iconv('windows-1251', 'utf-8', $_POST['comment']);
		$db->Query('UPDATE `db_chat` SET `comment` = "'.$db->RealEscape($_POST['comment']).'" WHERE `id` = '.intval($_GET['id']));
		$mess[] = "<div style='width: 465px' class='ok'>Сохранено</div>";
	}
	
	$comment = $db->FetchRow();
	$comment = iconv('utf-8', 'windows-1251', $comment);
?>	
	<form action="" method="post">
		<input class="input_text_m" style="height:50px; width:455px; margin: 10px 15px 10px 15px;" name="comment" type="text" value="<?=$db->RealEscape($comment);?>" />
		<input style="margin: 15px" name="edit_sub" type="submit" value="Сохранить" />
	</form>
<?
}
?>
<?php if(!empty($mess)) foreach($mess as $item) { echo $item; }?>
</div></div></div><div class="text_pages_bottom"></div></div>
