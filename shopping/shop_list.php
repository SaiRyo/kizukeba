<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheckShop();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// DBに接続
		$dsn      = 'mysql:dbname=shop;host=localhost';
		$user     = 'shoper';
		$password = 'shoper';
		$dbh      = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

		// sql文を使ってレコードを追加してます
		// where 1の「1」は「全部」という意味
		$sql    = 'SELECT code,name,price FROM mst_product WHERE 1';
		$stmt   = $dbh->prepare($sql);
		$stmt->execute();

		// db接続を切断
		$dbh = null;

		print '商品一覧<br /><br />';

		while(true) {
			//$stmtから1レコード取り出してる
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);

			// もしもうデータがなければループから脱出
			if ($rec==false) {
				break;
			}

			//スタッフの名前を$stmtから1レコードずつ取り出しながら表示
			// データが亡くなったらループから脱出
			//ラジオボタンでスタッフを選べるように
			print '<a href="shop_product.php?procode=' . $rec['code'] . '">';
			print $rec['name'] . '---';
			print $rec['price'] . '円';
			print '</a>';
			print '</br>';
		}

		print '<br />';
		print '<a href="shop_cartlook.php">カートを見る</a><br />';

	}
	// DBサーバーに障害が発生した時
	catch (exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		// 強制終了
		exit();
	}

?>
<body>

</body>