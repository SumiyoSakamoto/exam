<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<title>�С������ɺ����ץ����</title>
<style type="text/css">
<!--
table {
border: 1px lightgrey solid;
border-collapse: collapse;
width: 600px;
}
td, th {
border: 1px lightgrey solid;
text-align: center;
white-space: nowrap;
}
table.barcode {
border: none;
height: 1cm;
width: 85px;
}
td.white {
border: none;
background-color: white;
width: 1px;
}
td.black {
border: none;
background-color: black;
width: 1px;
}
-->
</style>
</head>

<body>
<font size=2>
�С������ɺ����ץ����
<hr>
<p>
<table>
<tr><th>No</th><th>���Ϥ��줿��</th><th>�С�������</th><th>��å�����</th></tr>

<?php
include ("./barcode.func");

$count = 1;	// ���Ϥ��줿���ͤο�
$start = 0;	// ���Ϥ��줿�ǡ�������ڤ뤿��Υݥ������
$datalen = strlen($_POST['number']);
do {
	// ���Ϥ��줿�ǡ�������1�����ƥ�ʥ���ޤޤǡˤ���Ф�
	$pos = strpos($_POST['number'], ',', $start);
	if ($pos === false)
		$pos = $datalen;
	$item = trim(substr($_POST['number'], $start, $pos - $start));
	$start = $pos + 1;

	$msg = "";	// ��å��������ɽ������ʸ����
	// �����ƥ��Ĺ���ȿ��ͤΥ����å�
	$len = strlen($item);
	if ($len == 0)
		$msg = "���ͤ����Ϥ���Ƥ��ޤ���<br>";
	else if ($len < 8)
		$msg = "���Ϥ��줿���ͤη夬­��ޤ���<br>";
	else if ($len > 8)
		$msg = "���Ϥ��줿���ͤη夬¿�����ޤ���<br>";
	else if (!(is_numeric($item)))
		$msg = "���Ϥ��줿�ͤϿ��ͤǤϤ���ޤ���<br>";

	print "<tr><td>" . $count++ . "</td>\n<td>" . $item . "</td>\n<td>";

	// �����ƥब�����Ǥʤ����Τߡ��С������ɤ�ɽ������
	if ($msg == "") {

		// �����å�����饯�������
		$check = getCheckChara($item);
		if ($check != $item[7])
			$msg = "���Ϥ��줿�ͤϲ���Ƥ����ǽ��������ޤ���";
?>
<table class="barcode">
<tr>
<?php
		// ��¦�Υޡ������ɽ��
		showLeftMargin();

		// ���Υ����ɥС���ɽ��
		showSideBar();

		// ���Ϥ��줿�ǡ�������Ƭ4���ɽ��
		for ($i=0;$i<4;$i++)
			showLeftBar($item[$i]);

		// ����ΥС���ɽ��
		showCenterBar();

		// ���Ϥ��줿�ǡ����θ��3���ɽ��
		for ($i=4;$i<7;$i++)
			showRightBar($item[$i]);

		// �����å�����饯����ɽ��
		showRightBar($check);

		// ���Υ����ɥС���ɽ��
		showSideBar();

		// ��¦�Υޡ������ɽ��
		showRightMargin();
?>
</tr></table>
<?php
	}
?>
</td>
<?php  
	print "<td>" . $msg . "</td></tr>"; 

} while($pos != $datalen);
?>

</table>
</p>
<input type="button" value="���" onclick="history.back()">
</font>
</body>
</html>
