<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Партнерская программа";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id = '$user_id'");
$refs = $db->FetchRow();
?>  

<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">
<div class="s_divide"></div>

         <div class="title_r">Ваша реферальная ссылка</div>
         <div class="text">
            Приглашайте в игру своих друзей и знакомых, Вы будете получать 10% от каждого пополнения баланса, от просмотра серфинга и выполнений заданий, приглашенным Вами человеком. 
			Доход ни чем не ограничен. <BR/>
			Даже несколько приглашенных могут принести вам более 100 000 Золота. 
			Ниже представлена ссылка для привлечения и количество приглашенных Вами.
         </div>
         <div class="clear"></div>  
         <div class="s_divide"></div>
          
         <input class="input_text w340" value="http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?>"/>
             <div class="s_divide"></div>
             <div class="title_r">Ваши реферальные баннеры:</div>
                <div class="input_wrap_b">
                    <label>Баннер 728x90</label>
                    <img src="http://<?=$_SERVER['HTTP_HOST']; ?>/images/promo/728.png" class="banner_preview1"/>
                    <input onclick="this.select()" class="input_text w340 banner_ref" readonly value='<a href="http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?>" target=_blank><img src="http://<?=$_SERVER['HTTP_HOST']; ?>/images/promo/728.png" alt="Mr.Farmer - зарабатывайте деньги на своем сельском хозяйстве!"></a>'/>
                </div>
                
                
<div class="input_wrap_b">
                    <label>Баннер 200x300</label>
                    <img src="http://<?=$_SERVER['HTTP_HOST']; ?>/images/promo/300.gif" class="banner_preview3"/>
                    <input onclick="this.select()" class="input_text w340 banner_ref" readonly value='<a href="http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?>" target=_blank><img src="http://<?=$_SERVER['HTTP_HOST']; ?>/images/promo/300.gif" alt="Mr.Farmer - зарабатывайте деньги на своем сельском хозяйстве!"></a>'/>
                </div>



            <div class="input_wrap_b">
                    <label>Баннер 468x60</label>
                    <img src="http://<?=$_SERVER['HTTP_HOST']; ?>/images/promo/468.png" class="banner_preview2"/>
                    <input onclick="this.select()" class="input_text w340 banner_ref" readonly value='<a href="http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?>" target=_blank><img src="http://<?=$_SERVER['HTTP_HOST']; ?>/images/promo/468.png" alt="Mr.Farmer - зарабатывайте деньги на своем сельском хозяйстве!"></a>'/>
                </div>
                
                
                
                
            <div class="s_divide"></div>
			<div class="title_r">Вы пригласили: <div style="float:right;">Всего (<?=$refs; ?>)</div></div>
<table width="95%">
<tr>
	<th class="m-tb" align="center" width=""> Логин </th>
	<th class="m-tb" align="center" width=""> Дата регистрации </th>
	<th class="m-tb" align="center" width=""> Доход от партнера </th>
</tr>

<?PHP
  $all_money = 0;
  $db->Query("SELECT db_users_a.user, db_users_a.date_reg, db_users_b.to_referer FROM db_users_a, db_users_b 
  WHERE db_users_a.id = db_users_b.id AND db_users_a.referer_id = '$user_id' ORDER BY to_referer DESC");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		if (sprintf("%.2f",$ref["to_referer"]) > 0) { $t = sprintf("%.2f",$ref["to_referer"]); } else { $t ='Не активен';}
		?>
		<tr class="">
			<td align="center"> <?=$ref["user"]; ?> </td>
			<td align="center"> <?=date("d.m.Y в H:i:s",$ref["date_reg"]); ?> </td>
			<td align="center"> <?=$t; ?> </td>
		</tr>

		<?PHP
		$all_money += $ref["to_referer"];
		}
  
	}else echo '<div class="err">У вас нет рефералов</div>'
  ?>

</table>
            
                
<div class="s_divide"></div>
</div>
<div class="text_pages_bottom"></div>
</div>
    