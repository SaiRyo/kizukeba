<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheck();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// 前の画面から受け取った入力データを変数にコピー
		$pro_code       = $_POST['code'];
		$pro_gazou_name = $_POST['gazou_name'];

		//DBに接続
		$dsn      = 'mysql:dbname=shop;host=localhost';
		/*
		$user     = 'root';
		$password = '1qaz"WSX';
		*/
		$user     = 'shoper';
		$password = 'shoper';

		$dbh      = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

		// sql文を使ってレコードを追加してます
		$sql    = 'delete from mst_product where code=?';
		$stmt   = $dbh->prepare($sql);	
		$data[] = $pro_code;
		$stmt->execute($data);

		// db接続を切断
		$dbh = null;

		// 画像がなかった存在する場合
		if($pro_gazou_name != '') {
			unlink('./gazou/' . $pro_gazou_name);
		}

	}
	// DBサーバーに障害が発生した時
	catch (exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		// 強制終了
		exit();
	}

?>
<body>

削除しました。<br />
<br />

<a href = "pro_list.php">戻る</a>


</body>