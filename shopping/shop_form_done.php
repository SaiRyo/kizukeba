<?php
session_start();
session_regenerate_id(true);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>ろくまる農園</title>
</head>
<body>

<?php

try{

	// クラスファイルの読み込み
	//include("../Common/CommonMethod.php");
	require_once('../Common/CommonMethod.php');

	// サニタイジング
	$post = CommonMethod::sanitize($_POST);

	$onamae = $post['onamae'];
	$email = $post['email'];
	$postal1 = $post['postal1'];
	$postal2 = $post['postal2'];
	$address = $post['address'];
	$tel     = $post['tel'];
	$chumon = $post['chumon'];
	$pass = $post['pass'];
	$danjo = $post['danjo'];
	$birth = $post['birth'];

	print $onamae.'様<br />';
	print 'ご注文ありがとうございました。<br />';
	print $email . 'に送りましたのでご確認ください。<br />';
	print '商品は以下の住所に発送させて頂きます。<br />';
	print $postal1 . '-' . $postal2 . '<br />';
	print $address . '<br />';
	print $tel . '<br />';

// ----------------------以下注文した商品の情報--------------------------

	$honbun = '';
	$honbun .= $onamae . "様\n\nこの度はご注文ありがとうございました。";
	$honbun .= "\n";
	$honbun .= "ご注文商品\n";
	$honbun .= "-------------\n";

	$cart = $_SESSION['cart'];
	$kazu = $_SESSION['kazu'];
	$max  = count($cart);

	//DBに接続
	$dsn      = 'mysql:dbname=shop;host=localhost';
	$user     = 'shoper';
	$password = 'shoper';
	$dbh      = new PDO($dsn, $user, $password);
	$dbh->query('SET NAMES utf8');	

	for($i = 0; $i < $max; $i++) {
		$sql = 'select name, price from mst_product where code = ?';
		$stmt = $dbh->prepare($sql);
		$data[0] = $cart[$i];
		$stmt->execute($data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

		$name = $rec['name'];
		$price = $rec['price'];
		$kakaku[] = $price;
		$suryo = $kazu[$i];
		$shokei = $price * $suryo;

		$honbun .= $name.' ';
		$honbun .= $price.'円 ×';
		$honbun .= $suryo.'個 =';
		$honbun .= $shokei."円\n";
	}

// ----------------------以上注文した商品の情報--------------------------

	$sql = 'LOCK tables dat_sales, dat_sales_product WRITE';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	$lastmembercode = 0;

	if($chumon == 'chumontouroku') {
		$sql = 'insert into dat_member
		(password, name, email, postal1, postal2, address, tel, danjo, born) 
		values (?, ?, ?, ?, ?, ?, ?, ?, ?)';

		$stmt = $dbh->prepare($sql);

		$data = array();
		$data[] = md5($pass);
		$data[] = $onamae;
		$data[] = $email;
		$data[] = $postal1;
		$data[] = $postal2;
		$data[] = $address;
		$data[] = $tel;

		if($danjo == 'dan') {
			$dan[] = 1;
		}
		else {
			$data[] = 2;
		}

		$data[] = $birth;
		$stmt->execute($data);

		$sql = 'select LAST_INSERT_ID()';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$lastmembercode = $rec['LAST_INSERT_ID()'];
	}

	$sql = 'insert into dat_sales(code_member, name, email, postal1, postal2, address, tel) 
	values (?,?,?,?,?,?,?)';
	$stmt = $dbh->prepare($sql);
	
	$data = array();
	//$data[] = 0;
	$data[] = $lastmembercode;
	$data[] = $onamae;
	$data[] = $email;
	$data[] = $postal1;
	$data[] = $postal2;
	$data[] = $address;
	$data[] = $tel;

	$stmt->execute($data);


	// 直近に発番された番号を取得する
	$sql = 'select LAST_INSERT_ID()';
	//prepareとは準備するという意味
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	$lastcode = $rec['LAST_INSERT_ID()'];

	for($i = 0; $i<$max; $i++) {
		$sql = 'insert into dat_sales_product(code_sales, code_product, price, quantity) 
		values (?, ?, ?, ?)';

		$stmt = $dbh->prepare($sql);
		$data = array();
		$data[] = $lastcode;
		$data[] = $cart[$i];
		$data[] = $kakaku[$i];
		$data[] = $kazu[$i];
		$stmt->execute($data);

	}

	$sql = 'UNLOCK tables';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	$dbh = null;

	if($chumon == 'chumontouroku') {
		print '会員登録が完了致しました。<br />';
		print '次回からメールアドレスとパスワードでログインしてください。<br />';
		print 'ご注文が簡単にできるようになります。<br />';
		print '<br />';
	}

	$honbun .= "送料は無料です。\n";
	$honbun .= "--------------\n";
	$honbun .= "\n";
	$honbun .= "代金は以下の口座にお振り込みください。\n";
	$honbun .= "ろくまる銀行　やさい支店　普通口座　１２３４５６７\n";
	$honbun .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
	$honbun .= "\n";

	if($chumon == 'chumontouroku') {
		$honbun .= "会員登録が完了致しました。\n";
		$honbun .= "次回からメールアドレスとパスワードでログインしてください。\n";
		$honbun .= "ご注文が簡単にできるようになります。\n";
		$honbun .= "\n";
	}

	$honbun .= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
	$honbun .= "〜安心野菜のろくまる農園〜\n";
	$honbun .= "\n";
	$honbun .= "京都府京都市北区\n";
	$honbun .= "電話 090-999-9999";
	$honbun .= "メール info@rokumarunouen.co.jp\n";
	$honbun .= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";

	//print '<br />';
	// nl2brで括ると\nは<br />に変換されて表示される。
	//print nl2br($honbun);

	//メールタイトル
	$title = 'ご注文ありがとうございます。';
	// 送信元のメールアドレス
	$header = 'From:info@rokumarunouen.co.jp';
	$honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
	mb_language('Japanese');
	mb_internal_encoding('UTF-8');
	// メールを送信する命令。$emailが送信先アドレス
	mb_send_mail($email, $title, $honbun, $header);


	//メールタイトル
	$title = 'お客様からご注文がありました。';
	// 送信元のメールアドレス
	$header = 'From:' . $email;
	$honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
	mb_language('Japanese');
	mb_internal_encoding('UTF-8');
	// メールを送信する命令。$emailが送信先アドレス
	mb_send_mail('info@rokumarunouen.co.jp', $title, $honbun, $header);
	
}
catch(Exeption $e) {
	print 'ただいま障害によりたへんご迷惑をお掛けしております。';
	exit();
}

?>

<br />
<a href="shop_list.php">商品画面へ</a>

</body>
</html>