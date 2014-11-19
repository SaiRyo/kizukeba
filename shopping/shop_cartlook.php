<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheckShop();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// cartが存在する場合
		if(isset($_SESSION['cart']) == true) {
			// 選択された商品コード。入力欄から受け取ってないのでサニタイジングはしていない
			//$pro_code = $_POST['procode'];
			// 保管していたカートの中身を戻します
			$cart = $_SESSION['cart'];

			$kazu = $_SESSION['kazu'];
			$max  = count($cart);			
		}
		else {
			$max = 0;
		}

		if($max == 0) {
			print 'カートに商品が入っていません。<br />';
			print '<br />';
			print '<a href = "shop_list.php">商品一覧へ戻る</a>';
			exit();
		}

		//DBに接続
		$dsn      = 'mysql:dbname=shop;host=localhost';
		$user     = 'shoper';
		$password = 'shoper';
		$dbh      = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

		// カートの商品の数ループ
		foreach($cart as $key => $val) {
			$sql = 'select code, name, price, gazou from mst_product where code = ?';
			$stmt = $dbh->prepare($sql);
			$data[0] = $val;
			$stmt->execute($data);

			$rec = $stmt->fetch(PDO::FETCH_ASSOC);

			$pro_name[] = $rec['name'];
			$pro_price[] = $rec['price'];

			// 画像ファイルが存在しない場合
			if($rec['gazou'] == '') {
				$pro_gazou[] = '';
			}
			else {
				$pro_gazou[] = '<img src = "../product/gazou/' . $rec['gazou'] . '">';
			}
		}

		//db切断
		$dbh = null;
/*
		// カートの商品の数ループ
		for($i = 0; $i < $max; $i++) {
			print $pro_name[$i];
			print $pro_gazou[$i];
			print $pro_price[$i];
			print '<br />';

		}
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

カートの中身<br />
<br />
<table border = "1">
<tr>
<td>削除</td>
<td>商品</td>
<td>商品画像</td>
<td>価格</td>
<td>数量</td>
<td>小計</td>
</tr>

<form method="post" action="kazu_change.php">
<?php 		// カートの商品の数ループ
		for($i = 0; $i < $max; $i++) {
?>

<tr>
<td>
	<input type="checkbox" name="sakujo<?php print $i; ?>">
</td>
<td>
	<?php
				print $pro_name[$i];
	?>
</td>
<td>
	<?php
				print $pro_gazou[$i];
	?>
</td>
<td>
<?php
			print $pro_price[$i];
?>円
</td>
<td>
<input type="text" name="kazu<?php print $i;?>" value="
<?php
			print $kazu[$i];
?>">

</td>

<td>
<?php print $pro_price[$i] * $kazu[$i]; ?>円
</td>

</tr>
<?php

		}

?>

</table>

<input type="hidden" name="max" value="<?php print $max;?>">
<input type="submit" value="数量変更"><br />
※削除する場合、チェックボックスを選択して数量変更ボタンをクリック<br />
<input type="button" onclick="history.back()" value="戻る">
</form>
<br />
<a href="shop_form.html">ご購入手続きへ進む</a><br />

<?php

if(isset($_SESSION["member_login"]) === true) {
	print '<a href="shop_kantan_check.php">会員かんたん注文へ進む</a><br />';
}

?>

</body>