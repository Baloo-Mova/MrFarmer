<?php if(empty($_SESSION["user"])) {?>
        <ul>
            
            <li><a href="/about.html" <?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "about") ? 'class="selected"' : False; ?>>
			<span class="fa fa-info-circle "></span> � �������</a>
			</li>
            <li><a href="/news.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "news") ? 'class="selected"' : False; ?>>
			<span class="fa fa-newspaper-o"></span> ��������� �������</a>
			</li>
            <li><a href="/"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "") ? 'class="selected"' : False; ?>>
			<span class="fa fa-fw fa-gamepad"></span> ���� <div class="new_label">�����!</div></a>
			</li>
            <li><a href="/otziv.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "otziv") ? 'class="selected"' : False; ?>>
			<span class="fa fa-comments-o"></span> ������</a>
			</li>
            <li><a href="/rules.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "rules") ? 'class="selected"' : False; ?>>
			<span class="fa fa-edit"></span> ����������</a>
			</li>
            <li><a href="/contacts.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "contacts") ? 'class="selected"' : False; ?>>
			<span class="fa fa-envelope"></span> ��������</a>
			</li>
        </ul>
<?php } ?>

        