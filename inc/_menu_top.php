<ul>
    <li><a href="/" <?=(!isset($_GET["menu"]) OR strtolower($_GET["menu"]) == "index") ? 'class="current"' : False; ?>>�������</a></li>
	<li><a href="/about.html" <?=(isset($_GET["menu"]) AND strtolower($_GET["menu"]) == "about") ? 'class="current"' : False; ?>>FAQ (� �������)</a></li>
    <li><a href="/news.html" <?=(isset($_GET["menu"]) AND strtolower($_GET["menu"]) == "news") ? 'class="current"' : False; ?>>�������</a></li>
    <li><a href="/otziv.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "otziv") ? 'class="selected"' : False; ?>>������</a></li>
<li><a href="/competition" <?=(isset($_GET["menu"]) AND strtolower($_GET["menu"]) == "competition") ? 'class="current"' : False; ?>>�������</a></li>	
<li><a href="/rules.html" <?=(isset($_GET["menu"]) AND strtolower($_GET["menu"]) == "rules") ? 'class="current"' : False; ?>>����������</a></li>		
    	<li><a href="/contacts.html" <?=(isset($_GET["menu"]) AND strtolower($_GET["menu"]) == "contacts") ? 'class="current"' : False; ?>>��������</a></li>
	
	<?php if(isset($_SESSION["user"])){?>
	<li><a class="logged" href="/account.html">������, <?=$_SESSION["user"]?>!</a></li>
	<li><a class="logged" href="/account/exit.html">�����</a></li>
	<?php } else { ?>
	<li><a href="/signup.html">����/�����������</a></li>
	<?php } ?>
</ul> 
