<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<title>バーコード作成プログラム</title>
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
バーコード作成プログラム
<hr>
<p>
<table>
<tr><th>No</th><th>入力された値</th><th>バーコード</th><th>メッセージ</th></tr>

<?php
include ("./barcode.func");

$count = 1;	// 入力された数値の数
$start = 0;	// 入力されたデータを区切るためのポジション
$datalen = strlen($_POST['number']);
do {
	// 入力されたデータから1アイテム（コンマまで）を取り出す
	$pos = strpos($_POST['number'], ',', $start);
	if ($pos === false)
		$pos = $datalen;
	$item = trim(substr($_POST['number'], $start, $pos - $start));
	$start = $pos + 1;

	$msg = "";	// メッセージ欄に表示する文字列
	// アイテムの長さと数値のチェック
	$len = strlen($item);
	if ($len == 0)
		$msg = "数値が入力されていません。<br>";
	else if ($len < 8)
		$msg = "入力された数値の桁が足りません。<br>";
	else if ($len > 8)
		$msg = "入力された数値の桁が多すぎます。<br>";
	else if (!(is_numeric($item)))
		$msg = "入力された値は数値ではありません。<br>";

	print "<tr><td>" . $count++ . "</td>\n<td>" . $item . "</td>\n<td>";

	// アイテムが不正でない場合のみ、バーコードを表示する
	if ($msg == "") {

		// チェックキャラクタを取得
		$check = getCheckChara($item);
		if ($check != $item[7])
			$msg = "入力された値は壊れている可能性があります！";
?>
<table class="barcode">
<tr>
<?php
		// 左側のマージンを表示
		showLeftMargin();

		// 左のガードバーを表示
		showSideBar();

		// 入力されたデータの先頭4桁を表示
		for ($i=0;$i<4;$i++)
			showLeftBar($item[$i]);

		// 中央のバーを表示
		showCenterBar();

		// 入力されたデータの後ろ3桁を表示
		for ($i=4;$i<7;$i++)
			showRightBar($item[$i]);

		// チェックキャラクタを表示
		showRightBar($check);

		// 右のガードバーを表示
		showSideBar();

		// 右側のマージンを表示
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
<input type="button" value="戻る" onclick="history.back()">
</font>
</body>
</html>
