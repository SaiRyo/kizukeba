<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheck();

	// postで受け取った情報をサニタイジング
	$post = CommonMethod::sanitize($_POST);

	//前の画面から入力データを受け取って変数に入れていく
	$pro_code           = $post['code'];
	$pro_name           = $post['name'];
	$pro_price          = $post['price'];
	$pro_gazou_name_old = $post['pro_gazou_name_old'];
	$pro_gazou          = $_FILES['gazou'];

	//もしスタッフ名が入力されていなかったら
	if($pro_name == ''){
		//「スタッフ名が入力されていません」と表示
		print '商品名が入力されていません。<br />';
	}
	// もしスタッフ名が入力されてたら
	else {
		print '商品名：';
		print $pro_name;
		print '<br />';
	}
	// もし半角数字じゃなかったら
	// 正なら1、誤なら0を返す
	if(preg_match('/^[0-9]+$/', $pro_price) == 0) {
		print '価格は半角数字で入力してください。<br />';
	}

	else {
		print '価格：';
		print $pro_price;
		print '円<br />';
	}

	// もし画像サイズが0より大きいならば
	if($pro_gazou['size'] > 0) {
		// ある一定のサイズより大きいなら
		if($pro_gazou['size'] > 1000000) {
			print '画像が大き過ぎです1MBより小さいサイズで指定してください。';
		}
		else {
			// 画像を[gazou]フォルダにアップロードする
			move_uploaded_file($pro_gazou['tmp_name'], './gazou/' . $pro_gazou['name']);
			print '<img src="./gazou/' . $pro_gazou['name'] . '">';
			print '<br />';
		}

	}	

	// もし、入力に問題があったら「戻る」ボタンだけを表示
	if($pro_name == ''|| preg_match('/^[0-9]+$/', $pro_price) == false || $pro_gazou['size'] > 1000000){
		print '<form>';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '< /form>';
	}
	// もし、入力に問題がなかったら、「戻る」ボタンと「OK」ボタンの両方を表示
	else {
		print '上記のように変更します。<br />';
		print '<form method="post" action="pro_edit_done.php">';
		print '<input type="hidden" name="code" value="'.$pro_code.'">';
		print '<input type="hidden" name="name" value="'.$pro_name.'">';
		print '<input type="hidden" name="price" value="'.$pro_price.'">';
		print '<input type="hidden" name="pro_gazou_name_old" value="'.$pro_gazou_name_old.'">';
		print '<input type="hidden" name="gazou_name" value="' .$pro_gazou['name'] .'">';
		print '<br />';
		print '<input type="button" onclick="histry.back()" value="戻る">';
		print '<input type="submit" value="OK">';
		print '</form>';
	}

//疑問点
//histry.back()とは
//htmlspecialcharactersとは
//input type="hidden"とは

?>
<body>


</body>