<?php
	header("Content-Type: text/html; charset=windows-1251");
?>

<div class="text_right">

<div class="s-bk-lf">
	<div class="acc-title">Список заданий</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<?php


$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

function colorSum($sum){

	if($sum >= 100) return "red";
	return "#000000";
}

if(isset($_POST['accept']) && is_numeric($_POST['accept'])) {
	$payed=$_POST['accept'];
	$db->Query("SELECT * FROM `db_jobs` WHERE `id` = '$payed' AND `accept` = '0' LIMIT 1 ");
        if($db->NumRows() > 0) {
	     $db->Query("UPDATE `db_jobs` SET `accept`='1' WHERE `id`='$payed' ");
        }
}

if(isset($_POST['decline']) && is_numeric($_POST['decline'])) {
	$payed=$_POST['decline'];
	$db->Query("SELECT * FROM `db_jobs` WHERE `id` = '$payed' AND `accept` = '0' LIMIT 1 ");
        if($db->NumRows() > 0) {
	     $db->Query("UPDATE `db_jobs` SET `accept`='2' WHERE `id`='$payed' ");
        }
}

$db->Query("SELECT * FROM db_jobs WHERE accept = 0 ORDER BY id DESC LIMIT {$lim}, 100");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" width="50" class="m-tb">Пользователь</td>
	<td align="center" width="300" class="m-tb">Текст</td>
	<td align="center" width="100" class="m-tb">URL</td>
	<td align="center" width="50" class="m-tb">Одобрить</td>
	<td align="center" width="100" class="m-tb">Дата</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
	<td align="center"><a href="/?menu=admin384&sel=users&edit=<?=$data["user_id"]; ?>"<?php if($data['gardener']==1) {echo ' style="color: red;"';}  ?> class="stn"><?=$data["user"]; ?></a></td>
	<td align="center"><?=$data['about']; ?></td>
	<td align="center"><?=$data['url']; ?></td>
	<td align="center">
	<?php
		if($data["accept"]==0) {
	?>
	<form action="" method="post">
	<input type="hidden" name="accept" value="<?=$data["id"]; ?>" />
	<input type="submit" value="Одобрить" />
	</form>
	<form action="" method="post">
	<input type="hidden" name="decline" value="<?=$data["id"]; ?>" />
	<input type="submit" value="Отменить" />
	</form>
	<?php
	}
	else if($data["accept"]==2)
	{
		echo "<center><font color = 'green'><b>Отменено!</b></font></center><BR />";
	}
	else
	{
		echo "<center><font color = 'green'><b>Одобрено!</b></font></center><BR />";
	}
	?>
	</td>
	<td align="center"><?=date("d.m H:i:s",$data["time"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP


}else echo "<center><b>На данной странице нет записей</b></center><BR />";

	
$db->Query("SELECT COUNT(*) FROM  db_jobs WHERE accept = 0 ");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "/?menu=admin384&sel=jobs&page="), "</center>";
	
	}
?>
</div><div class='clr'></div>

</div>
