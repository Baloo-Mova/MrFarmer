<?PHP
$_OPTIMIZATION["title"] = "��������";
$_OPTIMIZATION["description"] = "����� � ��������������";
$_OPTIMIZATION["keywords"] = "����� � �������������� �������";

if(isset($_POST['contact'])){
	$name = $_POST['name'];
	$email = $func->IsMail($_POST['email']);
	$text = $_POST['text'];
	if ($name !== false && $subject !== false && $email !== false && $text !== false) {
	
	$to = $email;
	$from = "support@mr-farmer.biz";
	$subject = $_POST['subject'];
	$subject = "=?windows-1251?B?".base64_encode($_POST['subject'])."?=";
	$headers = "From: $from\r\nReply-To: $to\r\nContent-type: text/plain; charset=windows-1251\r\n";
	mail($from, $subject, $text, $headers);
	
	$mess[] = "<div class='ok'>���� ��������� ������� ����������!</div>";
	} else $mess[] = "<div class='err'>��������� �� ��� ���� ��� ��������� �� �����!</div>";
}
?>
<div class="text_right">
	<div class="text_pages_top"></div>
	<div class="text_pages_content">
	<div class="s_divide"></div>
	<div class="text" style="padding-top:0px;">	
<?php if(!empty($mess)) foreach($mess as $item) { echo $item; }?>	
<div style="padding-top:10px;" class="text">
<div class="title_r">����� � ����</div>
���� ��������� �����-���� �������� ��� ������� �� ����, �� � �������� ������� ���. 
���� � ��� ���� �����������, ������� ������� ���� ��� ����� ����������, ����������, � ���� ��� ����������, 
�� �������� ������� ����� �� ���. 
<div class="s_divide"></div>
<div class="already_got">��� E-mail: <a href="mailto:support@mr-farmer.biz">support@mr-farmer.biz</a></div>
<div class="already_got">�� ���������: http://vk.com/mrfarmer<a href="http://vk.com/mrfarmer"></a></div>
<div class="clear"></div>
<div class="s_divide"></div>
<div class="title_r">��� ������ ��� ����� ����� �������� �����</div>
<div style="margin-right:10px;" class="narrow">
 <?php if(!empty($_SESSION["user"])) { ?>
<form method="post" action="">
	<input type="text" placeholder="���" class="input_text w340" name="name" value="" required />
	<input type="text" autocomplete="off" placeholder="����" class="input_text w340" name="subject" value="" required /> 
	<input type="text" placeholder="E-mail" class="input_text w340" name="email" value="" required />

</div>      
<div style="margin-right:7px;" class="narrow_r">       
<textarea placeholder="���������" class="input_text w340 textarea" name="text" value="" type="text" required></textarea> 
<input type="submit" class="subm_button" name="contact" value="������� ���������">
</div>
</form>
<?php } else { ?>
<div class="err">�������� ������ �������������� ������������!</div>
</div> 
<?php } ?>
</div>
</div>
</div>
<div class="text_pages_bottom"></div>
</div>