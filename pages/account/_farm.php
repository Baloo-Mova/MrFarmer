<?PHP
$_OPTIMIZATION["title"] = "�����";
$usid = $_SESSION["user_id"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
?>
<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">        
<div class="s_divide"></div>
<?php 
	if(isset($_POST["sbor"])){
	
		if($user_data["last_sbor"] < (time() - 600) ){
		
			$tomat_s = $func->SumCalc($sonfig_site["a_in_h"], $user_data["a_t"], $user_data["last_sbor"]);
			$straw_s = $func->SumCalc($sonfig_site["b_in_h"], $user_data["b_t"], $user_data["last_sbor"]);
			$pump_s = $func->SumCalc($sonfig_site["c_in_h"], $user_data["c_t"], $user_data["last_sbor"]);
			$peas_s = $func->SumCalc($sonfig_site["d_in_h"], $user_data["d_t"], $user_data["last_sbor"]);
			$pean_s = $func->SumCalc($sonfig_site["e_in_h"], $user_data["e_t"], $user_data["last_sbor"]);
			
			$db->Query("UPDATE db_users_b SET 
			a_b = a_b + '$tomat_s', 
			b_b = b_b + '$straw_s', 
			c_b = c_b + '$pump_s', 
			d_b = d_b + '$peas_s', 
			e_b = e_b + '$pean_s', 
			all_time_a = all_time_a + '$tomat_s',
			all_time_b = all_time_b + '$straw_s',
			all_time_c = all_time_c + '$pump_s',
			all_time_d = all_time_d + '$peas_s',
			all_time_e = all_time_e + '$pean_s',
			last_sbor = '".time()."' 
			WHERE id = '$usid' LIMIT 1");
			
			echo "<div class='ok'>�� ������� ������� ��� ���������!</div>";
			
			$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
			$user_data = $db->FetchArray();
			
		}else echo "<div class='err'>��������� ����� ������� �� ���� ��� 1 ��� � 10 �����!</div>";
	
	}



?>
��� ��������� ������� ��� �������� ���� �������� ����� �������� �� �����, ��������� �� � ����������. �� ������ ������ ��� ��� � 10 ���. 
��������� ��������� ������������� � �������� � ������������, �� ������ �������� �� ���� ��� � ����, ��� ��� �������.
<div class="clear"></div>
<div class="shop">
	<div class="block">
		<div class="block_name"></span>��������: ������</div>
		<div style="margin-top: -5px;" class="block_list"><ul class="block_ul">
		<li>��������������: <b><?=$sonfig_site["a_in_h"]; ?></b> � ���</li>
		<li>�������: <b><?=$user_data["a_t"]; ?></b> ��.</li>
		<li>
		���������: <span style="font-size: 22px;"><b>
		<?=$func->SumCalc($sonfig_site["a_in_h"], $user_data["a_t"], $user_data["last_sbor"]);?>
		</b></span> ���
		</li>
		</ul>
		</div>
		<div class="block_img"><img src="/images/animals/1.png" alt="������" title="������">
		</div>
	</div>
</div>

<div class="shop">
	<div class="block">
		<div class="block_name"></span>��������: ������</div>
		<div style="margin-top: -5px;" class="block_list"><ul class="block_ul">
		<li>��������������: <b><?=$sonfig_site["b_in_h"]; ?></b> � ���</li>
		<li>�������: <b><?=$user_data["b_t"]; ?></b> ��.</li>
		<li>
		���������: <span style="font-size: 22px;"><b>
		<?=$func->SumCalc($sonfig_site["b_in_h"], $user_data["b_t"], $user_data["last_sbor"]);?>
		</b></span> ����
		</li>
		</ul>
		</div>
		<div class="block_img"><img src="/images/animals/2.png" alt="������" title="������">
		</div>
	</div>
</div>

<div class="shop">
	<div class="block">
		<div class="block_name"></span>��������: ����</div>
		<div style="margin-top: -5px;" class="block_list"><ul class="block_ul">
		<li>��������������: <b><?=$sonfig_site["c_in_h"]; ?></b> � ���</li>
		<li>�������: <b><?=$user_data["c_t"]; ?></b> ��.</li>
		<li>
		���������: <span style="font-size: 22px;"><b>
		<?=$func->SumCalc($sonfig_site["c_in_h"], $user_data["c_t"], $user_data["last_sbor"]);?>
		</b></span> ����
		</li>
		</ul>
		</div>
		<div class="block_img"><img src="/images/animals/3.png" alt="����" title="����">
		</div>
	</div>
</div>

<div class="shop">
	<div class="block">
		<div class="block_name"></span>��������: ����</div>
		<div style="margin-top: -5px;" class="block_list"><ul class="block_ul">
		<li>��������������: <b><?=$sonfig_site["d_in_h"]; ?></b> � ���</li>
		<li>�������: <b><?=$user_data["d_t"]; ?></b> ��.</li>
		<li>
		���������: <span style="font-size: 22px;"><b>
		<?=$func->SumCalc($sonfig_site["d_in_h"], $user_data["d_t"], $user_data["last_sbor"]);?>
		</b></span> ������ ����
		</li>
		</ul>
		</div>
		<div class="block_img"><img src="/images/animals/4.png" alt="����" title="����">
		</div>
	</div>
</div>

<div class="shop">
	<div class="block">
		<div class="block_name"></span>��������: ������</div>
		<div style="margin-top: -5px;" class="block_list"><ul class="block_ul">
		<li>��������������: <b><?=$sonfig_site["e_in_h"]; ?></b> � ���</li>
		<li>�������: <b><?=$user_data["e_t"]; ?></b> ��.</li>
		<li>
		���������: <span style="font-size: 22px;"><b>
		<?=$func->SumCalc($sonfig_site["e_in_h"], $user_data["e_t"], $user_data["last_sbor"]);?>
		</b></span> ������ ������
		</li>
		</ul>
		</div>
		<div class="block_img"><img src="/images/animals/5.png" alt="������" title="������">
		</div>
	</div>
</div>

<form action="" method="post">
<center><input type="submit" name="sbor" value="������� ���" style="height:30px;"/></center>
</form>

</div>
<div class="text_pages_bottom"></div>
</div>	