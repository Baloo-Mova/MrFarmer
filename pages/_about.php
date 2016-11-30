<?PHP
$_OPTIMIZATION["title"] = "О проекте";
$_OPTIMIZATION["description"] = "О нашем проекте";
$_OPTIMIZATION["keywords"] = "Немного о нас и о нашем проекте";
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>
	<div class="text" style="padding-top:0px;">	
<?PHP

$db->Query("SELECT about FROM db_conabrul WHERE id = '1'");
$xt = $db->FetchRow();
echo $xt;
?>
</div>
</div>
<div class="text_pages_bottom"></div>
</div>