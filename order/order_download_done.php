<?php
include("../Common/CommonMethod.php");
CommonMethod::loginCheck();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// プルダウンメニューで選択された情報
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];

		//DBに接続
		$dsn      = 'mysql:dbname=shop;host=localhost';
		$user     = 'shoper';
		$password = 'shoper';
		$dbh      = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

		// sql文を使ってレコードを追加してます
		// where 1の「1」は「全部」という意味
		$sql    = '
		SELECT dat_sales.code, dat_sales.date, dat_sales.code_member, 
		dat_sales.name AS dat_sales_name, dat_sales.name, dat_sales.email, dat_sales.postal1, 
		dat_sales.postal2, dat_sales.address, dat_sales.tel, dat_sales_product.code_product, 
		mst_product.name AS mst_product_name, mst_product.name, dat_sales_product.price, 
		dat_sales_product.quantity FROM dat_sales, dat_sales_product, mst_product 
		where dat_sales.code = dat_sales_product.code_sales 
		and dat_sales_product.code_product = mst_product.code 
		and substr(dat_sales.date,1,4)=? and substr(dat_sales.date,6,2)=?
		and substr(dat_sales.date,9,2)=?
		';
		
		$stmt   = $dbh->prepare($sql);

		$data[] = $year;
		$data[] = $month;
		$data[] = $day;

		$stmt->execute($data);

		$csv = '注文コード, 注文日時, 会員番号, お名前, メール, 郵便番号, 住所, TEL, 商品コード, 商品名, 価格, 数量';
		$csv .= "\n";

		while(true) {
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);

			// 読み込むデータが無くなった場合
			if($rec === false) {
				break;
			}

			$csv .= $rec['code'];
			$csv .= ',';
			$csv .= $rec['date'];
			$csv .= ',';
			$csv .= $rec['code_member'];
			$csv .= ',';
			$csv .= $rec['dat_sales_name'];
			$csv .= ',';
			$csv .= $rec['email'];
			$csv .= ',';
			$csv .= $rec['postal1'] . '-' . $rec['postal2'];
			$csv .= ',';
			$csv .= $rec['address'];
			$csv .= ',';
			$csv .= $rec['tel'];
			$csv .= ',';
			$csv .= $rec['code_product'];
			$csv .= ',';
			$csv .= $rec['mst_product_name'];
			$csv .= ',';
			$csv .= $rec['price'];
			$csv .= ',';
			$csv .= $rec['quantity'];
			$csv .= "\n";
		}

		//print nl2br($csv);

		// 同じフォルダ内に書き込みコードで開く
		$file = fopen('./chumon.csv', 'w');

		// 文字コードをshift-JISに変換
		$csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');

		// ファイル書き込み
		fputs($file, $csv);

		// ファイルを閉じる
		fclose($file);

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
<a href="chumon.csv">注文データのダウンロード</a><br />
<br />
<a href="order_donwload.php">日付選択へ</a><br />
<br />
<a href="../staff_login/staff_top.php">トップメニューへ</a><br />
</body>