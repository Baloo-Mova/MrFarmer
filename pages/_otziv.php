<?
$_OPTIMIZATION["title"] = "Коментарии пользователей";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];
$db->Query("SELECT * FROM `db_coments`, `db_users_a` WHERE db_coments.comment_author = db_users_a.user  ORDER BY `date_comment` DESC LIMIT 15");
$data = $db->FetchArray();

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_data = $db->FetchArray();
?>
<?
if(isset($_POST['del_comm'])) {
	if ($usid == 1 && $usname === 'admin') {
	$id_comm = intval($_POST['id_comm']);
	$db->Query("DELETE FROM `db_coments` WHERE `comment_id` = '$id_comm'");
	$mess[] = "<div class='ok'>Коментарий удален!</div>"; 
	} else $mess[] = "<div class='err'>Ошибка удаления комментария!</div>"; 
}

if(isset($_POST['text'])){	
	$user = $usname;
	$text = trim ($_POST["text"]);
	$text = htmlspecialchars ($text);
	$title = trim ($_POST["title"]);
	$title = htmlspecialchars ($title);
	
	if ($title != false) {
	if ($text != false) {
			if (strlen($title) >= 5 && strlen($title) <= 100) {
			if (strlen($text) >= 10 && strlen($text) <= 500) {
						$db->Query("INSERT INTO `db_coments` (`comment_author`, `comment_title`, `comment_text`) 
						VALUES ('$user', '$title', '$text')");

						$db->Query("SELECT * FROM `db_coments`, `db_users_a` WHERE db_coments.comment_author = db_users_a.user  ORDER BY `date_comment` DESC LIMIT 15");
						$data = $db->FetchArray();
		Header("Location: /otziv.html");	
		}else $mess[] = "<div class='err'>Текст должен содержать только буквы и цифры не менее 20 и не более 500</div>";
		}else $mess[] = "<div class='err'>Заголовок должен содержать только буквы и цифры не менее 5 и не более 100</div>";
		} else $mess[]  = "<div class='err'>Введите текст комментария!</div>";
		} else $mess[]  = "<div class='err'>Введите заголовок комментария!</div>";

}
?>
<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content"> </div>
<div class="text_pages_content">
<div class="title_r"><center> Список всех отзывов о проекте</center></div>
<div class="text">
   В этом разделе Вы можете оставить свой отзыв о проекте. По скольку нас, а и других участников игры интересует Ваше реальное мнение, 
   мы не даем золото за положительные мнения. Также здесь можете делать предложения, которые кажутся Вам интересныe для развития игры.
</div>
<div class="s_divide"></div>
<?
$db->Query("SELECT * FROM `db_coments`, `db_users_a` WHERE db_coments.comment_author = db_users_a.user  ORDER BY `date_comment` DESC LIMIT 7");
if($db->NumRows() > 0){
?>
<?
while($data = $db->FetchArray()){
?>
<div class="comment">
	<div class="comment_left">  
		<div class="testimonial_number">
			<img width="50" height="50" alt="" class="avatar" src="/images/avatar/<?=$data['avatar'];?>"> 
		</div>
		<span>
			<?=$data["comment_author"]; ?>
		</span>
	</div>
	<div class="comment_right">
		<div class="message_content">
			<div class="comment_arrow"></div>
			<span><?=$data["comment_title"]; ?></span>
			<?=$data["comment_text"]; ?>
		</div>
		<div class="message_details">
			Дата: <?=$data["date_comment"]; ?>
			
				<?php 
				if($usid == 1 && $usname === 'admin') {?>
				<form name="del_comm" method="post" action="">
					<input type="hidden" name="id_comm" value="<?=$data["comment_id"];?>"/>
					<input class="del_com" type="submit" name="del_comm" value="Удалить коментарий"/>
				</form>
				<?php
				}?>
		</div>
	</div>
</div>
			
<?php
}
} else $mess[] = "<div class='err'>Не оставлено ни одного комментария!</div>";
?>


<?if (isset($_SESSION["user_id"])) { 
?>
<div class="s_divide"></div>
<div class="title_r"> Напишите отзыв </div>
<?php if(!empty($mess)) foreach($mess as $item) { echo $item; }?>
<form id="form_id" method="post" action="">
<div class="inp_wrap">
	<label>Заголовок</label>
	<input type="text" value="" class="input_text_m" name="title">
</div>
<div class="clear"></div>
<div class="inp_wrap">
<label>Отзыв</label>
<textarea class="input_text_m textarea textstyle" name="text" rows="8" cols="80"></textarea>
</div>
<div class="clear"></div>
<input class="subm_button" type="submit" value="Добавить отзыв">
</form>

<? } else { ?>
<div class="err">Чтобы оставить коментарий вы должны быть авторизованы.</div>
<? } ?>
<div class="s_divide"></div>

</div>
<div class="text_pages_bottom"></div>
</div>