<?php
$_OPTIMIZATION["title"] = "Аккаунт - Камень-Ножницы-Бумага";
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];

$knbItem[1] = 'Камень';
$knbItem[2] = 'Ножницы';
$knbItem[3] = 'Бумага';
?>
<div class="s-bk-lf">
	<div class="acc-title">Камень-Ножницы-Бумага</div>
</div>
<div class="silver-bk">
	<table class="table1" align="center">
  <tr class="title">
    <td>
		<form action="/account/knb/" method="post">
		Ставка: <input name="summa" type="text" value="<?php echo isset($_POST['summa'])?htmlspecialchars($_POST['summa']):'100'; ?>" size="5" /> | Предмет: 
		<?php
			$r = rand(1, 3);
		?> 
		<select name="item">
			<option value="1" <?php if($r == 1) echo 'selected="selected"'; ?>>Камень</option>
			<option value="2" <?php if($r == 2) echo 'selected="selected"'; ?>>Ножницы</option>
			<option value="3" <?php if($r == 3) echo 'selected="selected"'; ?>>Бумага</option>
		</select>
		<input class="green" name="play_sub" type="submit" value="Создать" />
		</form>
	</td>
  </tr>
  </table>
  
<?php
if(isset($_POST["play_sub"])){
	$db->Query('SELECT `money_b` FROM `db_users_b` WHERE id = '.$usid);
	$u_balance = $db->FetchRow();
	
	$summa = round($_POST["summa"], 2);

		$err = NULL;
		if($summa < 10)
			$err .= "<li>Минимальная ставка 10</li>";
		if($_POST["item"] > 3 OR $_POST["item"] <1)
			$_POST["item"] = rand(1,3);
		if($summa > $u_balance)
			$err .= "<li>На балансе недостаточно средств</li>";
			
		if($err == NULL){
			$db->Query('UPDATE `db_users_b` SET `money_b` = `money_b` - '.$summa.' WHERE id = '.$usid);
			$db->Query("INSERT INTO `db_games_knb` (`summa`, `item`, `login`, `dat`) VALUES (".$summa.", ".intval($_POST['item']).", '".$uname."', '".date("Y-m-d H:i:s")."')");
			header('location: /account/knb');
		}else{
			echo "<ul class='error'>".$err."</ul>";
		}
	}
?>			
<script type="text/javascript">
$(function(){

$('#imgitems img').hover(function(){
	$(this).attr('src', '/img/items/rooms-' + $(this).attr('alt') + '-1.png');
}, function(){
	$(this).attr('src', '/img/items/rooms-' + $(this).attr('alt') + '.png');
});


$('#imgitems img').click(function(){
$('input[name="item"]').val($(this).attr('alt'));
$('form.play'+$(this).attr('class')).submit();
});

$('#play').submit(function(e){
//отменяем стандартное действие при отправке формы
e.preventDefault();
//берем из формы метод передачи данных
var m_method=$(this).attr('method');
//получаем адрес скрипта на сервере, куда нужно отправить форму
var m_action=$(this).attr('action');
//получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
//то есть в стандартном формате передачи данных формы
var m_data=$(this).serialize();
$.ajax({
type: m_method,
url: m_action,
data: m_data,
success: function(result){
$('#test_form').html(result);
}
});
});
});
</script>
<div id="test_form"></div>
<style type="text/css">
table1{border-collapse: collapse; border-spacing: 0px; margin: 0px; padding: 0px; width:100%; vertical-align:top; text-align:center;}
.table1 td{padding:6px; border-bottom: 1px solid #98C1D7; text-align:center;}
.table1 .title td{border-bottom: 2px solid #98C1D7; font-weight:700;}
.table1 tr:nth-child(2n+1){background: #F4F4F4;}
</style>

<?php
$db->Query("SELECT * FROM `db_games_knb` ORDER BY `id`");

if($db->NumRows() == 0){
	echo '<ul><li>Игр нет</li></ul>';
	echo '</div>';
	return;
}

echo '<table class="table1" align="center">';
echo '<tr>';
	echo '<td>Сумма</td>';
	echo '<td>от пользователя</td>';
	echo '<td>&nbsp;</td>';
echo '</tr>';
while($row = $db->FetchArray()){
echo "<div id='play-".$row["id"]."'>
<tr>
<td>".$row["summa"]."</td>
<td>".htmlspecialchars($row["login"])."</td>
<td>".($row["login"] == $uname?"
	<form action='/account/knb/' method='post'>
		Ваш предмет: ".$knbItem[$row["item"]]."
	</form>":"
	<form class='play-".$row["id"]."' id='play' action='/ajax/game_play.php' method='post'>
		<input name='id' type='hidden' value='".$row["id"]."' />
		<input id='item' name='item' type='hidden' value='' />
		<div id='imgitems'> 
			<img  class='-".$row["id"]."' src='/img/items/rooms-1.png' alt='1' />
			<img  class='-".$row["id"]."' src='/img/items/rooms-2.png' alt='2' />
			<img  class='-".$row["id"]."' src='/img/items/rooms-3.png' alt='3' />
		</div>
	</form>")."</td></tr></div>";
}
echo '</table>';
?>  
</div>