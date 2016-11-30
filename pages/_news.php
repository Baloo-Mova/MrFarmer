<?PHP
$_OPTIMIZATION["title"] = "Новости";
$_OPTIMIZATION["description"] = "Новости проекта";
$_OPTIMIZATION["keywords"] = "Новости нашего проекта";
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>
	<div class="text" style="padding-top:0px;">
<?PHP

$db->Query("SELECT * FROM db_news ORDER BY id DESC");

if($db->NumRows() > 0){

	while($news = $db->FetchArray()){
	
	?>

            
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left"><h3><?=$news["title"]; ?></h3></td>
    <td align="right"><strong><?=date("d.m.Y",$news["date_add"]); ?></strong></td>
  </tr>

  <tr>
    <td colspan="2"><?=$news["news"]; ?></td>
  </tr>
</table> 
<BR />
	<?PHP
	
	}

}else echo "<center>
новостей нету (.</center>";

?>
</div>
</div>
<div class="text_pages_bottom"></div>
</div>	