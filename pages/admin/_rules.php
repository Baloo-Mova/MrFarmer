<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">	
<script type="text/javascript" src="/js/editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		editor_deselector : "mceNoEditor",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright",
		
		theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect,|,fullscreen,media,advhr",
		
		theme_advanced_buttons3 : "bullist,numlist,|,outdent,indent,blockquote,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons4 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell",
		theme_advanced_buttons5 : "",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css : "editor/css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		extended_valid_elements : "iframe[*]",
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		},

		
		// Style formats
		style_formats : [

			{title : 'DEFAULT', inline : 'span', classes : 'text-content'}
		],
		
		
		// Enable translation mode
		translate_mode : true,
		language : "ru"
	});
</script>
<?PHP

	if(isset($_POST["tx"])){
	
		$db->Query("UPDATE db_conabrul SET rules = '".$_POST["tx"]."' WHERE id = '1'");
		echo "<center><font color = 'green'><b>Сохранено</b></font></center><BR />";
	}

$db->Query("SELECT * FROM db_conabrul WHERE id = '1'");
$data = $db->FetchArray();
?>

<form action="" method="post">
<textarea name="tx" cols="78" rows="25"><?=$data["rules"]; ?></textarea>
<BR /><BR />
<center><input type="submit" value="Сохранить" /></center>
</form>
</div>
<div class="text_pages_bottom"></div>
</div>
