<?PHP
$_OPTIMIZATION["title"] = "������� - ������ �������������";
?>
<div class="container_down">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>
	<div class="text" style="padding-top:0px;">	
<?php 
$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

$db->Query("SELECT * FROM db_users_a ORDER BY id LIMIT {$lim}, 100");

if($db->NumRows() > 0){

?>
<table width="100%" border="0">
  <tr bgcolor="#efefef">
    <td align="center" width="75">ID</td>
    <td align="center">������������</td>
    <td align="center">Email</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
	<td align="center"><?=str_replace(substr($data["email"],2,3), '<font color="red">***</font>', $data["email"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP

}else echo "<center><b>�� ������ �������� ��� �������</b></center><BR />";

$db->Query("SELECT COUNT(*) FROM db_users_a");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "/users/"), "</center>";
	
	}
?>
</div>
</div>
<div class="text_pages_bottom"></div>
</div>