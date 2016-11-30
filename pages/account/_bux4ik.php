<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Коробка удачи";
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
# Настройки бонусов
$amount_lottery = 500; 
$bonus_min = 0;
$bonus_max = 2000;

?>

<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">  
<div class="" style="padding-top:0px;">
<center><b>Коробка удачи</b></center>

<style>
.silver-bklobux4ik {
background: url("../img/sunduk.png") center no-repeat;
border: 1px solid #dddddd;
width: 250;
border-radius: 4px;
margin: -10px 0px 0px 0px;
padding: 10px 12px 10px 12px;
color: #7ea57b;
font-weight: bold;
text-shadow: #fff 0 2px 9px;
margin-top: 5px;
}


.silver-bkloxum {
background: #f7f7f7;
border: 1px solid #dddddd;
width: 250;
border-radius: 4px;
margin: -10px 0px 0px 0px;
padding: 10px 12px 10px 12px;
color: #7ea57b;
font-weight: bold;
text-shadow: #fff 0 2px 9px;
margin-top: 5px;
}

</style>

<center>Одна игра стоит <b><?=$amount_lottery;?></b> монет, вы можете выиграть до <b><?=$bonus_max;?></b> монет.<BR /></center>

<p> </p>
<form action="" method="post">
<center>
<center>
<div class="silver-bkloxum">

<?PHP
$ddel = time() + 0*0*0;
$dadd = time();

$db->Query("SELECT COUNT(*) FROM db_baraban4ik WHERE user_id = '$usid' AND date_del > '$dadd'");
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");

$user_data = $db->FetchArray();
$stavka = intval($user_data["money_b"]);
$hide_form = false;


	if($db->FetchRow() == 0){

		# Выдача бонуса
		if(isset($_POST["bonus"])){
		
	    	if($stavka <= $user_data['money_b']) {
		    if($stavka >= 300) {
		
			
			$sum = rand($bonus_min, rand($bonus_min, $bonus_max) );
			
			
			
			# Зачилсяем юзверю
			$db->Query("UPDATE db_users_b SET money_b = money_b + '$sum' WHERE id = '$usid'");
			
			# Вносим запись в список бонусов
		
			$db->Query("UPDATE db_users_b SET money_b = money_b - '$amount_lottery' WHERE id = '{$usid}'");
			$db->Query("INSERT INTO db_baraban4ik (user, user_id, sum, date_add, date_del) VALUES ('$uname','$usid','$sum','$dadd','$ddel')");
			
			# Случайная очистка устаревших записей
			$db->Query("DELETE FROM db_baraban4ik WHERE date_del < '$dadd'");
			
			echo "<center><font color = 'green'><b>Вы выиграли  {$sum} монет</b></font></center>";

	
			
			$hide_form = false;
			
			
			
			}else echo "<center><font color='red'>Недостаточно средств на балансе!</font>";
			
			}else echo "<center><font color='red'>Недостаточно средств на балансе!</font>";	
		}
		
			
			# Показывать или нет форму
			if(!$hide_form){
?>
</div>

</center>
<div class="silver-bklobux4ik">
<br>
<br>
<br>

  <br> 


<script type="text/javascript" src="/js/baraban4ik/jqueryrotate.2.1.js"></script>

<script type="text/javascript"> jQuery(document).ready(function() {
// Функция статичного поворота на 45 градусов
jQuery("#rotate1").rotate(45);

// Постоянное вращение картинки
var angle = 0;
setInterval(function(){
angle+=3;
jQuery("#rotate2").rotate(angle);
},1);

// Поворот при наведении курсора на 180 градусов
jQuery("#rotate3").rotate({
bind:
{
mouseover : function() {
$(this).rotate({animateTo:-180})
},
mouseout : function() {
$(this).rotate({animateTo:0})
}
}
});
});

</script>

<center><img src="/img/baraban4ik.png" style="height: 70px; width: 70px;" id="rotate2" /></center>




  <tr>
    <td align="center"></td>
  </tr>
  
<p> </p>
  <br>
  <br> 
 <center>  <input type="submit" name="bonus" class="btn_3d" value="Остановить стрелку" style="height: 30px; width: 200px; margin-top:10px;"></center>

</div>
</center>

</form>


<?PHP 

			}

	}else echo "<center><font color = 'red'><b>.</b></font></center><BR />"; ?>




<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><h4>Последние 20 участники</h4></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">ID</td>
    <td align="center" class="m-tb">Пользователь</td>
	<td align="center" class="m-tb">Сумма</td>
	<td align="center" class="m-tb">Дата</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM db_baraban4ik ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($bon = $db->FetchArray()){
		
		?>
		<tr class="htt">
    		<td align="center"><?=$bon["id"]; ?></td>
    		<td align="center"><?=$bon["user"]; ?></td>
    		<td align="center"><?=$bon["sum"]; ?></td>
			<td align="center"><?=date("d.m.Y",$bon["date_add"]); ?></td>
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">Нет записей</td></tr>'
  ?>

  
</table>

</div>
</div>
<div class="text_pages_bottom"></div>
</div>



