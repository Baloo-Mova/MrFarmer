<?php 
session_start();
define('MinRating', 300);
function __autoload($name){ include("../classes/_class.".$name.".php");}
$_POST['comment']=iconv('utf-8', 'windows-1251', $_POST['comment']);

class Chat{
	var $db;
	function __construct(){
		$config = new config;
		$this->db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
	}

	function send(){
		$res = $this->db->Query('SELECT `time_uban` FROM `db_chat_ban` WHERE `user` = "'.$_SESSION["user"].'"');
		if($this->db->NumRows() > 0){
			$row = $this->db->FetchArray();	
			if($row['time_uban'] > time())
				return '<span style="color:#f00">Вы забанены до '.date('Y.m.d H:i', $row['time_uban']).'</span>';
		}
		if(trim($_POST['comment']) == NULL)
			return '<span style="color:#f00">Введите сообщение</span>';
		$res = $this->db->Query('SELECT `time` FROM `db_chat` WHERE `user` = "'.$_SESSION["user"].'" ORDER BY `id` DESC  LIMIT 1');
		$lasttime = $this->db->FetchRow();
		if($lasttime > time()- 3)
			return '<span style="color:#f00">Нельзя отправлять сообщения так часто.</span>';
		
		
		$this->db->Query('INSERT INTO `db_chat` (`user`, `to`, `comment`, `time`) VALUES ("'.$_SESSION["user"].'", "'.$this->db->RealEscape($to).'", "'.$this->db->RealEscape($_POST['comment']).'", "'.time().'")');	
		$this->db->Query('DELETE FROM `db_chat` WHERE `id` < '.($this->db->LastInsert() - 100));
		return '<span style="color:#0f0">Сообщение отправлено</span>';
	}
	
	function get(){
		$res = $this->db->Query('SELECT `chat_moder` FROM `db_users_a` WHERE `user` = "'.$_SESSION["user"].'"');
		$chat_moder = $this->db->FetchRow();
		$res = $this->db->Query('SELECT * FROM `db_chat` ORDER BY `id` DESC');
		$str = NULL;
		while($row = $this->db->FetchArray()){
			$str .= $this->get_str($row, $chat_moder);
		}
		return $str;
	}
	
	function get_str($row, $chat_moder){
		$str = '<span class="user">'.htmlspecialchars($row['user']).'</span> <span class="time">('.date('Y.m.d в H:i:s', $row['time']).')</span>: '.$this->bb_code($row['comment']).'';
		
		if($row['to'] == $_SESSION["user"])
			$str = '<span class="to">'.$str.'</span>';	
		
		if($chat_moder == 1)
			$str .= ' (<a href="/chat/edit/'.$row['id'].'" title="Редактировать">Редакт.</a> 
			<a href="/chat/del/'.$row['id'].'" title="Удалить">Удалить.</a> 
			<a href="/chat/ban/'.$row['user'].'" title="Забанить/Розбанить пользователя">Бан/Розбан</a>)';	
		
		$str = $str.'<br />';	
		
		if($row['type'] == 1){
			if($chat_moder != 1 AND $row['to'] != $_SESSION["user"] AND $row['user'] != $_SESSION["user"])
				$str = NULL;
			else
				$str = '<span class="private">'.$str.'</span>';
				
		}
		
		return $str;
	}
	
	function _echo($str){
		echo $str;
	}
	
	function bb_code($str){
		$str = htmlspecialchars($str);
		$str = preg_replace('#\[b\](.+?)\[/b]#', '<span style="font-weight:900;">$1</span>',$str); 
		$str = preg_replace('#\[i\](.+?)\[/i]#', '<span style="font-style:italic;">$1</span>',$str); 
		$str = preg_replace('#\[u\](.+?)\[/u]#', '<span style="text-decoration:underline;">$1</span>',$str); 
		$str = preg_replace('#\[s\](.+?)\[/s]#', '<span style="text-decoration:line-through;">$1</span>',$str);
		
		$str = preg_replace('#\*smile\*#', '<img src="/img/chat/smile/smile.gif" alt="" />',$str);
		$str = preg_replace('#\*sadness\*#', '<img src="/img/chat/smile/sadness.gif" alt="" />',$str);
		$str = preg_replace('#\*laugh\*#', '<img src="/img/chat/smile/laugh.gif" alt="" />',$str);
		$str = preg_replace('#\*wonder\*#', '<img src="/img/chat/smile/wonder.gif" alt="" />',$str);
		$str = preg_replace('#\*tongue\*#', '<img src="/img/chat/smile/tongue.gif" alt="" />',$str);
		$str = preg_replace('#\*dance\*#', '<img src="/img/chat/smile/dance.gif" alt="" />',$str);
		$str = preg_replace('#\*THUMBS_UP\*#', '<img src="/img/chat/smile/THUMBS_UP.gif" alt="" />',$str);
		$str = preg_replace('#\*dont\*#', '<img src="/img/chat/smile/dont.gif" alt="" />',$str);
		
		$str = preg_replace('#\*kez_02\*#', '<img src="/img/chat/smile/kez_02.gif" alt="" />',$str);
		$str = preg_replace('#\*alvarin_34\*#', '<img src="/img/chat/smile/alvarin_34.gif" alt="" />',$str);
		$str = preg_replace('#\*drag_06\*#', '<img src="/img/chat/smile/drag_06.gif" alt="" />',$str);
		$str = preg_replace('#\*kidrock_07\*#', '<img src="/img/chat/smile/kidrock_07.gif" alt="" />',$str);
		return $str;
	}
}

$chat = new Chat();

if($_GET['p'] == 'send'){
	$chat->_echo($chat->send());	
}

if($_GET['p'] == 'get'){
	$chat->_echo('
			<script type="text/javascript">
				$(function(){
					$(\'#chat .history .user\').click(function(){
						$(\'#chat .message input[name="comment"]\').val($(this).text() + \', \' + $(\'#chat .message input[name="comment"]\').val());
						$(\'#chat .message input[name="to"]\').val($(this).text());
					});
				});
			</script>'.$chat->get());
}
?>