<?PHP
$_OPTIMIZATION["title"] = "������� ";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];
?>
<div class="text_right">
<div class="text_pages_top"></div>
<div class="text_pages_content">
             
<div class="s_divide"></div>

<?php 
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

# ������� ������ ������
if(isset($_POST["item"])){

$array_items = array(1 => "a_t", 2 => "b_t", 3 => "c_t", 4 => "d_t", 5 => "e_t");
$array_name = array(1 => "������", 2 => "������", 3 => "����", 4 => "����", 5 => "������");
$item = intval($_POST["item"]);
$citem = $array_items[$item];

	if(strlen($citem) >= 3){
		
		# ��������� �������� ������������
		$need_money = $sonfig_site["amount_".$citem];
		if($need_money <= $user_data["money_b"]){
		
			if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) ){
				
				$to_referer = $need_money * 0.1;
				# ��������� ������ � ��������� ������
				$db->Query("UPDATE db_users_b SET money_b = money_b - $need_money, $citem = $citem + 1,  
				last_sbor = IF(last_sbor > 0, last_sbor, '".time()."') WHERE id = '$usid'");
				
				# ������ ������ � �������
				$db->Query("INSERT INTO db_stats_btree (user_id, user, tree_name, amount, date_add, date_del) 
				VALUES ('$usid','$usname','".$array_name[$item]."','$need_money','".time()."','".(time()+60*60*24*15)."')");
				
				echo "<div class='ok'>�� ������� ������ ��������: '".$array_name[$item]."'!</div>";
				
				$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
				$user_data = $db->FetchArray();
				
			}else echo "<div class='ok'>����� ��� ��� �������� �������� �������� ��������� �� �����!</div>";
		
		}else echo "<div class='err'>�� ����� ����� �� ���������� ������� ��� ������� ��������: '".$array_name[$item]."'!</div>";
	
	}else echo 222;

}

?>
<div class="text">
� ���� �������� �� ������ ���������� ��������� ��������.
������ �������� �������� ���� ���������, ������� ����� ����� ������� �� ����� � �������� �� �������� ������. 
������ �������� ���� ��������� ���������� ���������, ��� �������� ������, ��� ������ ��������.
<div class="hintsmall">

</div>
</div>
<div class="clear"></div>

<div class="shop">
	<div class="block">
		<div class="block_name"></span>��������: ������</div>
		<div style="margin-top: -5px;" class="block_list"><ul class="block_ul">
		<li>��������������: <b><?=$sonfig_site["a_in_h"]; ?></b> � ���</li>
		<li>�������: <b><?=$user_data["a_t"]; ?></b> ��.</li>
		<li>
		<form method="post" action="/account/shop.html">
		<input type="hidden" value="1" name="item">
		<input type="submit" class="subm_button" style="float: right;margin-top: 10px;" value="������">
		</form>
		����: <span style="font-size: 22px;"><b><?=$sonfig_site["amount_a_t"]; ?></b></span> �����
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
		<form method="post" action="/account/shop.html">
		<input type="hidden" value="2" name="item">
		<input type="submit" class="subm_button" style="float: right;margin-top: 10px;" value="������">
		</form>
		����: <span style="font-size: 22px;"><b><?=$sonfig_site["amount_b_t"]; ?></b></span> �����</li></ul>
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
		<form method="post" action="/account/shop.html">
		<input type="hidden" value="3" name="item">
		<input type="submit" class="subm_button" style="float: right;margin-top: 10px;" value="������">
		</form>
		����: <span style="font-size: 22px;"><b><?=$sonfig_site["amount_c_t"]; ?></b></span> �����</li></ul>
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
		<form method="post" action="/account/shop.html">
		<input type="hidden" value="4" name="item">
		<input type="submit" class="subm_button" style="float: right;margin-top: 10px;" value="������">
		</form>
		����: <span style="font-size: 22px;"><b><?=$sonfig_site["amount_d_t"]; ?></b></span> �����</li></ul>
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
		<form method="post" action="/account/shop.html">
		<input type="hidden" value="5" name="item">
		<input type="submit" class="subm_button" style="float: right;margin-top: 10px;" value="������">
		</form>
		����: <span style="font-size: 22px;"><b><?=$sonfig_site["amount_e_t"]; ?></b></span> �����</li></ul>
		</div>
		<div class="block_img"><img src="/images/animals/5.png" alt="������" title="������">
		</div>
	</div>
</div>
        



</div>
<div class="text_pages_bottom"></div>
</div>


