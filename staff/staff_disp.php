<?php

	include("../Common/CommonMethod.php");

	CommonMethod::loginCheck();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// 選択されたスタッフコード。入力欄から受け取ってないのでサニタイジングはしていない
		//$staff_code = $_POST['staffcode'];
		$staff_code = $_GET['staffcode'];

		//DBに接続
		$dsn      = 'mysql:dbname=shop;host=localhost';
		$user     = 'shoper';
		$password = 'shoper';
		$dbh      = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

		// sql文を使ってレコードを追加してます
		// where 1の「1」は「全部」という意味
		$sql    = 'SELECT name FROM mst_staff WHERE code = ?';
		$stmt   = $dbh->prepare($sql);
		$data[] = $staff_code;
		$stmt->execute($data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		//print_r($rec);
		$staff_name = $rec['name'];

		// db接続を切断
		$dbh = null;
/*
		print 'スタッフ一覧<br /><br />';

		// 修正画面に飛ぶ
		print '<form method = "post" action = "staff_edit.php">';

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
			print '<input type = "radio" name = "staffcode" value="'.$rec['code'].'">';
			print $rec['name'];
			print '</br>';
		}

		print '<input type = "submit" value = "修正">';
		print '</form>';
*/
	}
	// DBサーバーに障害が発生した時
	catch (exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		// 強制終了
		exit();
	}

?>

<body>

スタッフ情報参照<br />
<br />
スタッフコード<br />
<?php print $staff_code;?>
<br />
スタッフ名<br />
<?php print $staff_name;?>
<br />
<br />
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>