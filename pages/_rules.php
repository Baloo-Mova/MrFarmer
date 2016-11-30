<?PHP
$_OPTIMIZATION["title"] = "Правила";
$_OPTIMIZATION["description"] = "Общие правила проекта";
$_OPTIMIZATION["keywords"] = "Правила, помятка пользователя, правила проекта";
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>
	<div class="text" style="padding-top:0px;">	
<?PHP

$db->Query("SELECT rules FROM db_conabrul WHERE id = '1'");
$xt = $db->FetchRow();
echo $xt;
?>
</div>
</div>
<div class="text_pages_bottom"></div>
</div>