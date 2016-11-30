<?php if(empty($_SESSION["user"])) {?>
        <ul>
            
            <li><a href="/about.html" <?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "about") ? 'class="selected"' : False; ?>>
			<span class="fa fa-info-circle "></span> О проекте</a>
			</li>
            <li><a href="/news.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "news") ? 'class="selected"' : False; ?>>
			<span class="fa fa-newspaper-o"></span> Последние новости</a>
			</li>
            <li><a href="/"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "") ? 'class="selected"' : False; ?>>
			<span class="fa fa-fw fa-gamepad"></span> Игры <div class="new_label">Скоро!</div></a>
			</li>
            <li><a href="/otziv.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "otziv") ? 'class="selected"' : False; ?>>
			<span class="fa fa-comments-o"></span> Отзывы</a>
			</li>
            <li><a href="/rules.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "rules") ? 'class="selected"' : False; ?>>
			<span class="fa fa-edit"></span> Соглашение</a>
			</li>
            <li><a href="/contacts.html"<?=(isset($_GET["menu"]) && strtolower($_GET["menu"]) == "contacts") ? 'class="selected"' : False; ?>>
			<span class="fa fa-envelope"></span> Контакты</a>
			</li>
        </ul>
<?php } ?>

        