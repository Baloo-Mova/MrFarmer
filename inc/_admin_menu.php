
<div class="acc-title">����� ������</div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=config">���������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=stats">����������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=story_buy">������� �������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=story_swap">������� �������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=story_insert">������� ����������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=pay_systems">��������� �������</a></div>
<div class="field-gr"><a href="/?menu=helpmyadmin&sel=story_sell">������� �� �����</a></div>
<div class="field-gr"><a href="/?menu=helpmyadmin&sel=compconfig">������� ���������</a></div>
<div class="field-gr"><a href="/?menu=helpmyadmin&sel=news">�������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=about">� �����</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=rules">�������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=users">������ �������������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=sender">�������� ��������</a></div>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=jobs">�������</a></div>
	<!--<div class="field-gr"><a href="/?menu=helpmyadmin&sel=serfing">�������</a></div>-->
<?php
if (isset($_SESSION['admin']))
{
	$db->Query("SELECT * FROM db_serfing WHERE status = '1' ORDER BY time_add DESC");
	?>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=serfing_moder">������������� (<?php echo $db->NumRows(); ?>)</a></div>
	<?php
}
?>
	<div class="field-gr"><a href="/?menu=helpmyadmin&sel=payments">������ ������</a></div>
<div class="field-rd"><a href="/account/exit.html">����� �� �������</a></div>
<br />
<br />
<br />
<br />