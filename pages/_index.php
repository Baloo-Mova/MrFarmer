

<?php
$db->Query("SELECT * FROM db_config");
$config = $db->FetchArray();
?>
<div class="wrapper">
<div style="margin-top:0px;" class="container">
<div class="farmer">
<div class="main_wrapper">
	<div class="main_market">
	<span class="title aligncenter">�������</span>
		<span class="rates_list">
			<ul>
				<li class="tips" style="width:200px !important;" original-title="������">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/1.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_a_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="������">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/2.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_b_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="����">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/3.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_c_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="����">
					<div class="main_rate_w"><img class="fa_icon" src="/images/animals/4.png"></div> 
					<div class="equals">=</div> 
					<div class="main_pr">
						<?=$config['amount_d_t'];?>                                                
					</div>
					<img width="31" class="p_m_left" src="/images/gold.png">
				</li>
				<li class="tips" style="width:200px !important;" original-title="������">
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
			<div class="title aligncenter">��� �������� MR.Farmer?</div>
			<ul>
				<li>
					<div class="number">1.</div>
					<div class="hint">����������������� ��� ������� � �������</div>
				</li>
				<li>
					<div class="number">2.</div>
					<div class="hint">
					Mr.Farmer ��� ����������� ����� ������ ���������, ��� ������, �������� �� ���� ����������� ����� ������������ �������� ������, 
					��� ����������� �� ����� ��� ������ . 

					</div>
				</li>
				<li>
					<div class="number">3.</div>
					<div class="hint">
					��� ������ ������� �� �������� ����� ��������, ��� ������ ����� ��� ���������.
					</div>
				</li>
				<li>
					<div class="number">4.</div>
					<div class="hint">
					��������� ��������� ������ ����! 
					</div>
				</li>
				<li>
					<div class="number">5.</div>
					<div class="hint">
					���������� ��������� ��������� � ��������� ������, ����� �������� ��� �������� � ����������� ���� �����</div>
				</li>
				<li>
					<div class="number">6.</div>
					<div class="hint">
					����������� � ���� ����� ������ � ��������.
					�� ������ �������� 10% �� ������� ���������� �������, ��������� ������ � �������� � ���������� ������� ������������� ���� ��������.</div>
				</li>
				<li>
					<div class="number">7.</div>
					<div class="hint">
					�� ������ ������� ���� ����������� ������ � ����� �����. ����������� �� PAYEER
					</div>
				</li>
			</ul>
		</div>
	</div>

	<div class="main_rates">
		<span class="title aligncenter">�����</span>
		<span class="rates_list">
		<ul>
		<li class="tips" style="width:200px !important;" original-title="����">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/1.png"></div> 
			<div class="equals">=</div> <?=$config['a_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/eggs.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="����">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/2.png"></div> 
			<div class="equals">=</div> <?=$config['b_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/meat.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="������">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/3.png"></div> 
			<div class="equals">=</div> <?=$config['c_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/wool.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="������ ����">
			<div class="main_rate_w"><img class="fa_icon" src="/images/animals/4.png"></div> 
			<div class="equals">=</div> <?=$config['d_in_h'];?> 
			<img width="30" class="p_m_left" src="/images/milk.png"> 
		</li>
		<li class="tips" style="width:200px !important;" original-title="������ ������">
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
                        <div class="title aligncenter">��������������� � ���:</div>
                        <div class="intro">
                            <div class="because_wrap">
                                <div class="m_1"></div>
                                <div class="because_text">
                                    100 ������� ����� ��� �����������!
                                </div>
                            </div>
                            <div class="because_wrap">
                                <div class="m_2"></div>
                                <div class="because_text">
                                    10% � ������� ����������!
                                </div>
                            </div>
                            <div class="because_wrap">
                                <div class="m_3"></div>
                                <div class="because_text">
                                    ����������� � ���� ����� ������ � ��������. 
									�� ������ �������� 10% �� ������� ���������� �������, ��������� ������ � �������� � ���������� ������� ������������� ���� ��������.
                                </div>
                            </div>
                        </div>
                       <div class="s_divide"></div>
                       <div class="title aligncenter">��� ����� Mr.Farmer?</div>
                       <div class="intro">
                            <p>
								Mr.Farmer ��� ����������� ����� ������ ���������, ��� ������,  
								�������� �� ���� ����������� ����� ������������ �������� ������, ��� ����������� �� ����� ��� ������ .
								��� ������ ������� �� �������� ����� ��������, ��� ������ ����� ��� ���������.
							</p> 
							<p>
								�������� ������� ��������� 
								���� ����� ����� ��������� �� ����� �� �������� ������, 
								������� ����� ��������������� ������� ����� �������� ��� ������� �� �������� ������.
								����� ����� ���� ����������� ������, ������� ���������� ������(Gold). 
								� ��� ������� ��� �����, ���� ��� ���������� � ���� �� �����.
							</p> 
							<p>
								������������� �������� ����� �������� ������ 10 �����, ������ ��� ��� ����� ��� �������, 
								��������� ��������� ������� �� �������� �� ������.
							</p>  
							<p>
								��������� ������ �� ������, �� ��������� 10% �� ���� �� ���������� �������, �������� � �������.
							</p>
                       </div>
                </div>
                <div class="right_login">
                    <div class="title_r">����</div>
                        <form name="loginform" action="/login.html" method="post">
						<input name="login" type="text" value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" placeholder="������������" class="input_text"/> 
						<input name="email" type="text" placeholder="E-mail" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>" class="input_text"/>
						<input name="pass" type="password" placeholder="������" class="input_text"/></td>
						<div class="clear"></div>
						<input type="submit" class="subm_button" value="����" name="loginform">
						</form>
                        <div class="clear"></div>
                        <div class="s_divide"></div> 
                        <div class="title_r">�����������</div>
						<form name="singup" method="post" action="/signup.html">
						<input type="text" placeholder="������������"  value="<?=(isset($_POST["login"])) ? htmlspecialchars($_POST["login"]) : false; ?>" name="login" class="input_text"/>
						<input type="text" placeholder="E-mail" value="<?=(isset($_POST["email"])) ? htmlspecialchars($_POST["email"]) : false; ?>"/ name="email" class="input_text"/>
						<input type="password" placeholder="������" value="" name="password" class="input_text"/>
						<input type="password" placeholder="����������� ������" value="" name="re_password" class="input_text"/>
						<div class="clear"></div>
						<div class="terms_main">
						<input type="checkbox" name="rules"/> <label for="terms">� �������� � ���������� � <a href="/rules.html" target="_blank">���������</a> ������������� �����</label>
						</div>
						<input type="submit" class="subm_button" value="�����������" name="singup"/>

						</form>
                </div>
        </div>
		<?php } ?>
    </div>
</div>

