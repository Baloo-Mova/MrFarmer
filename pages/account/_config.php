<?PHP
$_OPTIMIZATION["title"] = "Настройки";
$usid = $_SESSION["user_id"];

$db->Query("SELECT * FROM db_users_a WHERE id = '$usid'");
$user_data = $db->FetchArray();
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>
	<div class="text" style="padding-top:0px;">
<?PHP 
if (isset($_POST['config'])) {
	
	if($db->changeFloor(intval($_POST['floor']), $_SESSION['user']) === false){
	$mess[] = "<div class='err'>Ошибка!</div>";
	} 
	else {
	$mess[] = "<div class='ok'>Настройки успешно сохранены!</div>";
	}
	
	if (intval($_POST['delete_image']) == 1) {
		$delete = intval($_POST['delete_image']);
		$db->deleteAvatar($delete, $_SESSION['user']);
		if ($db->deleteAvatar($delete, $_SESSION['user']) === false) {
		$mess[] = "<div class='err'>Ошибка при удалении аватара!</div>";
		}
		else {
		$mess[] = "<div class='ok'>Аватар успешно удален!</div>";
		}
	} 
 
	if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] != "") {
		$avatar = $_FILES['avatar'];
		if($db->isSecurity($avatar)) { 
		$db->loadAvatar($avatar, $_SESSION['user']); 
		$mess[] = "<div class='ok'>Аватар успешно установлен!</div>";
		}
		else {
		$mess[] = "<div class='err'>Ошибка при установки аватара!</div>";
		}
	} 

	if ($_POST['password'] != "") {
		$pass = $func->IsPassword($_POST["password"]);
		$re_pass = $func->IsPassword($_POST["re_password"]);
		if($db->changePassword($pass, $re_pass, $_SESSION['user']) === false) {
		$mess[] = "<div class='err'>Ошибка при изменения пароля! Проверьте правильность заполнения полей!</div>";
		}
		else {
		$mess[] = "<div class='ok'>Пароль успешно установлен!</div>"; 
		}
	}
}
	
?>
<?php if(!empty($mess)) foreach($mess as $item) { echo $item; }?>
<form name="config" enctype="multipart/form-data" method="post" action="">  
	<div class="profile_left">
		<div class="inp_wrap">
			<label>E-mail</label>
			<input type="text" style="text-transform:lowercase;" readonly="" class="input_text w340 disable" name="email" value="<?=$user_data['email'];?>"> 
		</div>
		<div class="inp_wrap"> 
			<label>Пользователь</label>
			<input type="text" maxlength="36" max="36" min="2" readonly="" class="input_text w340 disable" name="username" value="<?=$user_data['user'];?>"> 
		</div>
		<div class="inp_wrap">
			<label>Пароль</label>
			<input type="password" maxlength="36" max="36" min="2" class="input_text w340" name="password" value=""> 
		</div>
		<div class="inp_wrap">
			<label>Подтвердить пароль</label>
			<input type="password" maxlength="36" max="36" min="2" class="input_text w340" name="re_password" value=""> 
		</div>
		<?php 
		$db->Query("SELECT * FROM db_users_a WHERE id = '$usid'");
		$user_data = $db->FetchArray();
		?>
		<div class="inp_wrap">
			<label>Пол</label>
			<select class="input_select w360" id="floor" name="floor"> 
				<option <? if ($user_data['floor'] == 1) echo 'selected="selected"' ?> value="1">Муж</option>
				<option <? if ($user_data['floor'] == 2) echo 'selected="selected"' ?> value="2">Женщина</option>
			</select>
		</div>
	</div>
	<div class="profile_right">
		<div class="profile_avatar">
		<?php
		$useravatar = $db->getAvatar($_SESSION['user']);
		if ($avatar == "") $avatar = "no.png";
		echo '<img class="avatar_pic" src="../images/avatar/'.$useravatar.'">';
		?>
			
			<div class="remove_avatar">
				<input type="checkbox" maxlength="36" max="36" min="2" class="f-check" name="delete_image" value="1" id="delete">
				<label for="delete">Удалить аватар</label>
			</div>
		</div>
	<div class="clear"></div>
	<div class="file_button_container_ru">
		<input type="file" name="avatar" size="30" style="height: 39px;width: 130px;;">
	</div>
	</div>
<div class="s_divide_s"></div>
	<input type="submit" class="subm_button" name="config" value="Сохранить изменения">
</form>


</div>
</div>
<div class="text_pages_bottom"></div>
</div>




