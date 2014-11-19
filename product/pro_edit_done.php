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
		$pro_code           = $post['code'];
		$pro_name           = $post['name'];
		$pro_price          = $post['price'];
		$pro_gazou_name_old = $post['gazou_name_old'];
		$pro_gazou_name     = $post['gazou_name'];

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
		$sql    = 'update mst_product set name=?, price=?, gazou=? where code=?';
		$stmt   = $dbh->prepare($sql);
		$data[] = $pro_name;
		$data[] = $pro_price;
		$data[] = $pro_gazou_name;
		$data[] = $pro_code;
		$stmt->execute($data);

		// db接続を切断
		$dbh = null;

		// 古い画像が合った場合削除する
		if($pro_gazou_name_old != $pro_gazou_name) {

			if($pro_gazou_name_old != '') {
				unlink('./gazou/' . $pro_gazou_name_old);

			}
		}

		print '修正しました。<br />';


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