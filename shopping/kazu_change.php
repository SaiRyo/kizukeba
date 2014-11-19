<?php

// 合言葉を確認する
session_start();
// 自分のパソコンとサーバーだけの間で毎回合言葉を変更
// セッションIDが盗まれないようにする(セッションハイジャック対策のため)
session_regenerate_id(true);

// クラスファイルの読み込み
include("../Common/CommonMethod.php");

// サニタイジング
$post = CommonMethod::sanitize($_POST);

$max = $post['max'];

// 商品数分ループ
for($i=0; $i<$max; $i++) {
	// 正数値以外の値だった場合
	if(preg_match("/^[0-9]+$/", $post['kazu'.$i]) == 0) {
		print '数量に誤りがあります。';
		print '<a href = "shop_cartlook.php">カートに戻る</a>';
		exit();
	}
	// 数量チェック
	if($post['kazu'.$i] < 1 || 10 < $post['kazu'.$i]) {
		print '数量は必ず1個以上、10個までです。';
		print '<a href="shop_cartlook.php">カートに戻る</a>';
		
		//print '<a href="shop_cartlook.php">カートに戻る</a>';
		exit();
	}
	// 入力された数量格納
	$kazu[] = $post['kazu'.$i];
}

$cart = $_SESSION['cart'];

for($i=$max; 0<=$i; $i--) {
	if(isset($_POST['sakujo'.$i]) == true) {
		array_splice($cart, $i, 1);
		array_splice($kazu, $i, 1);
	}
}

$_SESSION['cart'] = $cart;
$_SESSION['kazu'] = $kazu;

header('Location:shop_cartlook.php');

?>