<?php

	include("../Common/CommonMethod.php");

	CommonMethod::loginCheck();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// postで送られてきた情報をサニタイジング
		$post = CommonMethod::sanitize($_POST);

		// 前の画面から受け取った入力データを変数にコピー
		$staff_code = $post['code'];
		$staff_name = $post['name'];
		$staff_pass = $post['pass'];

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
		$sql    = 'update mst_staff set name=?, password=? where code=?';
		$stmt   = $dbh->prepare($sql);
		$data[] = $staff_name;
		$data[] = $staff_pass;		
		$data[] = $staff_code;
		$stmt->execute($data);

		// db接続を切断
		$dbh = null;


	}
	// DBサーバーに障害が発生した時
	catch (exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		// 強制終了
		exit();
	}

?>
<body>

修正しました。<br />
<br />

<a href = "staff_list.php">戻る</a>


</body>