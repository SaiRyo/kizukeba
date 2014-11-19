<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheckShop();

	// DBサーバの障害対策。エラートラップという
	try
	{
		// 選択された商品コード。入力欄から受け取ってないのでサニタイジングはしていない
		//$pro_code = $_POST['procode'];
		$pro_code = $_GET['procode'];

		// $_SESSION['cart']が存在する場合($_SESSIONにカートが入っていれば)
		if(isset($_SESSION['cart']) == true) {
			// 現在のカート内容をコピー
			$cart   = $_SESSION['cart'];	
			//cartが存在するならkazuも存在するので同じif文でOK
			$kazu = $_SESSION['kazu'];	

			// すでにカートに入れた商品が存在する場合
			if(in_array($pro_code, $cart) == true) {
				print 'その商品はすでにカートに入っています。<br />';
				print '<a href = "shop_list.php">商品一覧に戻る</a>';
				exit();
			}
		}

		// カートに入れた商品を追加
		$cart[] = $pro_code;

		$kazu[] = 1;
		// 最新のカート内容をセッションに保存
		$_SESSION['cart'] = $cart;

		$_SESSION['kazu'] = $kazu;

	}
	// DBサーバーに障害が発生した時
	catch (exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		// 強制終了
		exit();
	}

?>
<body>

カートに追加しました。<br />
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>