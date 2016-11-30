

<?php
$db->Query("SELECT * FROM db_config");
$config = $db->FetchArray();
?>
<div class="wrapper">
<div style="margin-top:0px;" class="container">
<div class="farmer">
<div class="main_wrapper">
	<div class="main_market">
	<span class="title aligncenter">Магазин</span>
		<span class="rates_list">
			<ul>
				<li class="tips" style="width:200px !important;" original-title="Курица">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/1.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_a_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="Свинья">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/2.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_b_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="Овца">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/3.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_c_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="Коза">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/4.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_d_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="Корова">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/5.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_e_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
			</ul>																																																																																																																																																																																																																																																																																																																																	</ul>
		</span>
	</div>
	<div class="regpanel">
		<div class="farmerville"></div>
		<div class="left_h">
			<div class="title aligncenter">Как работает MR.Farmer?</div>
			<ul>
				<li>
					<div class="number">1.</div>
					<div class="hint">Зарегистрируйтесь или войдите в систему</div>
				</li>
				<li>
					<div class="number">2.</div>
					<div class="hint">
					Mr.Farmer это виртуальная ферма нового поколения, где каждый, которому не лень потрудиться может зарабатывать реальные деньги, 
					без ограничений на вывод или баллов . 

					</div>
				</li>
				<li>
					<div class="number">3.</div>
					<div class="hint">
					Чем больше времени Вы уделяете Вашим животным, тем больше будет Ваш заработок.
					</div>
				</li>
				<li>
					<div class="number">4.</div>
					<div class="hint">
					Собирайте продукцию каждый день! 
					</div>
				</li>
				<li>
					<div class="number">5.</div>
					<div class="hint">
					Продавайте собранную продукцию и получайте Золото, чтобы покупать ещё животных и увеличивать свой доход</div>
				</li>
				<li>
					<div class="number">6.</div>
					<div class="hint">
					Приглашайте в игру своих друзей и знакомых.
					Вы будете получать 10% от каждого пополнения баланса, просмотра сайтов в серфинге и выполнения заданий приглашенного Вами человека.</div>
				</li>
				<li>
					<div class="number">7.</div>
					<div class="hint">
					Вы можете вывести свои накопленные деньги в любое время. Автовыплаты на PAYEER
					</div>
				</li>
			</ul>
		</div>
	</div>

	<div class="main_rates">
		<span class="title aligncenter">Рынок</span>
		<span class="rates_list">
		<ul>
		<li class="tips" style="width:200px !important;" original-title="Яйцо">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/1.png"></div> 
			<div class="equals">=</div> <?=$config['a_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/eggs.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="Мясо">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/2.png"></div> 
			<div class="equals">=</div> <?=$config['b_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/meat.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="Шерсть">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/3.png"></div> 
			<div class="equals">=</div> <?=$config['c_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/wool.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="Молоко козы">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/4.png"></div> 
			<div class="equals">=</div> <?=$config['d_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/milk.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="Молоко коровы">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/5.png"></div> 
			<div class="equals">=</div> <?=$config['e_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/milk.png"> 
		</li>
		</ul>																																																																					 </ul>
		</span>
	</div>
</div>

</div>
   <?php if(empty($_SESSION["user"])){ ?>
         <div class="register_login">
                <div class="left_login">
                        <div class="title aligncenter">Присоединяйтесь к нам:</div>
                        <div class="intro">
                            <div class="because_wrap">
                                <div class="m_1"></div>
                                <div class="because_text">
                                    100 Золотых монет при регистрации!
                                </div>
                            </div>
                            <div class="because_wrap">
                                <div class="m_2"></div>
                                <div class="because_text">
                                    10% к первому пополнению!
                                </div>
                            </div>
                            <div class="because_wrap">
                                <div class="m_3"></div>
                                <div class="because_text">
                                    Приглашайте в игру своих друзей и знакомых. 
									Вы будете получать 10% от каждого пополнения баланса, просмотра сайтов в серфинге и выполнения заданий приглашенного Вами человека.
                                </div>
                            </div>
                        </div>
                       <div class="s_divide"></div>
                       <div class="title aligncenter">Что такое Mr.Farmer?</div>
                       <div class="intro">
                            <p>
								Mr.Farmer это виртуальная ферма нового поколения, где каждый,  
								которому не лень потрудиться может зарабатывать реальные деньги, без ограничений на вывод или баллов .
								Чем больше времени Вы уделяете Вашим животным, тем больше будет Ваш заработок.
							</p> 
							<p>
								Продукты которые произвела 
								Ваша ферма можно продавать на рынке за реальные деньги, 
								которые можно реинвестировать покупая новых животных или вывести за реальные деньги.
								Ферма имеет свою собственную валюту, которая называется Золото(Gold). 
								У Вас имеется два счета, один для инвестиций и один на вывод.
							</p> 
							<p>
								Произведенные продукты можно собирать каждые 10 минут, каждый час или когда Вам удобнее, 
								собранная продукция никогда не пропадет со склада.
							</p>  
							<p>
								Приглашая друзей на проект, вы получаете 10% от всех их пополнений баланса, серфинга и заданий.
							</p>
                       </div>
                </div>
                <div class="right_login">
                    <div class="title_r">Вход</div>
                        <form name="loginform" action="/login.html" method="post">
						<input name="login" type="text" value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" placeholder="Пользователь" class="input_text"/> 
						<input name="email" type="text" placeholder="E-mail" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>" class="input_text"/>
						<input name="pass" type="password" placeholder="Пароль" class="input_text"/></td>
						<div class="clear"></div>
						<input type="submit" class="subm_button" value="Вход" name="loginform">
						</form>
                        <div class="clear"></div>
                        <div class="s_divide"></div> 
                        <div class="title_r">Регистрация</div>
						<form name="singup" method="post" action="/signup.html">
						<input type="text" placeholder="Пользователь"  value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" name="login" class="input_text"/>
						<input type="text" placeholder="E-mail" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>"/ name="email" class="input_text"/>
						<input type="password" placeholder="Пароль" value="" name="password" class="input_text"/>
						<input type="password" placeholder="Подтвердить пароль" value="" name="re_password" class="input_text"/>
						<div class="clear"></div>
						<div class="terms_main">
						<input type="checkbox" name="rules"/> <label for="terms">Я прочитал и соглашаюсь с <a href="/rules.html" target="_blank">условиями</a> использования сайта</label>
						</div>
						<input type="submit" class="subm_button" value="Регистрация" name="singup"/>

						</form>
                </div>
        </div>
		<?php } ?>
    </div>
</div>

