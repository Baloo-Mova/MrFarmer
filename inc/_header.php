<!DOCTYPE html>
<html>
		<title>Mr.Farmer|{!TITLE!}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
		<meta name="description" content="{!DESCRIPTION!}">
		<meta name="keywords" content="{!KEYWORDS!}">
		<link href="/style/style.css" rel="stylesheet" type="text/css" />
		<link href="/style/any.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/functions.js"></script>
		<style type="text/css">
 .spoiler_body { display:none; font-style:italic; }
 .spoiler_links { cursor:pointer; font-weight:bold; text-decoration:underline; }
 .blue { color:#000099; }
 .green { color:#009900; }
</style>
	</head>
	<body>
	<div class="body_wrap">
		<div class="menu">
			<div class="wrapper">
				<div class="top">
					<ul>
					<li><a href="/" class="fa home topicons"><img src="/images/icon/home.png"/ alt="home" title="Главная"></a></li>
					<li><a target="_blank" href="https://vk.com/mrfarmer" class="fa topicons"><img src="/images/icon/vk.png"/ alt="vk" title="Mr.Farmer в Контакте"></a></li>
					<li><a target="_blank" href="https://www.facebook.com/mrfarmerbiz/" class="fa topicons"><img src="/images/icon/f.png"/ alt="f" title="Mr.Farmer в Фейсбуке"></a></li>
					<li><a target="_blank" href="https://www.ok.ru/group/53248141820121" class="fa topicons"><img src="/images/icon/ok.png"/ alt="ok" title="Mr.Farmer в Одноклассниках"></a></li>
					</ul>
					<div class="right_lang">
						
					</div>
					<div class="right_menu">
						<?PHP include("inc/_menu_top.php"); ?>
					</div>
				</div>
			</div>
		</div>	
		<noscript>
			<div class="err">У вас отключен JavaScript! Вы не можете играть!</div>
		</noscript>
		<div class="wrapper">
			<?php include("inc/_stats.php");?>
		</div>	
		<div class="wrapper">
			<div class="container_down">
			
				
				<?php if(!empty($_GET['menu']) || !empty($_GET['sell'])) include("inc/_menu_left.php"); ?>
				
	