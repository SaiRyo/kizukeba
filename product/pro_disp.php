<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheck();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// 選択された商品コード。入力欄から受け取ってないのでサニタイジングはしていない
		//$pro_code = $_POST['procode'];
		$pro_code = $_GET['procode'];

		//DBに接続
		$dsn      = 'mysql:dbname=shop;host=localhost';
		$user     = 'shoper';
		$password = 'shoper';
		$dbh      = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

		// sql文を使ってレコードを追加してます
		// where 1の「1」は「全部」という意味
		$sql    = 'SELECT name,price,gazou FROM mst_product WHERE code = ?';
		$stmt   = $dbh->prepare($sql);
		$data[] = $pro_code;
		$stmt->execute($data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		//print_r($rec);
		$pro_name       = $rec['name'];
		$pro_price      = $rec['price'];
		$pro_gazou_name = $rec['gazou'];

		// db接続を切断
		$dbh = null;

		// もし商品画像がない場合
		if($pro_gazou_name =='') {
			$disp_gazou = '';
		}

		else {
			$disp_gazou = '<img src="./gazou/'.$pro_gazou_name.'">';
		}


/*
		print 'スタッフ一覧<br /><br />';

		// 修正画面に飛ぶ
		print '<form method = "post" action = "pro_edit.php">';

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
			print '<input type = "radio" name = "procode" value="'.$rec['code'].'">';
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

商品情報参照<br />
<br />
商品コード<br />
<?php print $pro_code;?>
<br />
商品名<br />
<?php print $pro_name;?>
<br />
価格<br />
<?php print $pro_price;?>円
<br />
<?php print $disp_gazou; ?>
<br />
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>