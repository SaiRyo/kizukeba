<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheck();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// postで受け取った情報をサニタイジング
		$post = CommonMethod::sanitize($_POST);

		// 前の画面から受け取った入力データを変数にコピー
		$pro_name       = $post['name'];
		$pro_price      = $post['price'];
		$pro_gazou_name = $post['gazou_name'];

		//DBに接続
		$dsn       = 'mysql:dbname=shop;host=localhost';
		/*
		$user     = 'root';
		$priceword = '1qaz"WSX';
		*/
		$user      = 'shoper';
		$password  = 'shoper';

		$dbh       = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

		// sql文を使ってレコードを追加してます
		$sql    = 'insert into mst_product(name, price, gazou) value (?,?,?)';
		$stmt   = $dbh->prepare($sql);
		$data[] = $pro_name;
		$data[] = $pro_price;
		$data[] = $pro_gazou_name;
		
		$stmt->execute($data);

		// db接続を切断
		$dbh = null;

		print $pro_name;
		print 'を追加しました。<br />';


	}
	// DBサーバーに障害が発生した時
	catch (exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		// 強制終了
		exit();
	}

?>

<body>



<a href = "pro_list.php">戻る</a>


</body>