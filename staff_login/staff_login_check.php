<?php

include("../Common/CommonMethod.php");

try {
	// postで受け取った情報をサニタイジング
	$post = CommonMethod::sanitize($_POST);

	$staff_code = $post['code'];
	$staff_pass = $post['pass'];

	// md5ハッシュ値を計算して暗号化された16進数の32文字の文字列を取得
	$staff_pass = md5($staff_pass);

    // DB情報
	$dsn      = 'mysql:dbname=shop;host=localhost';
	$user     = 'shoper';
	$password = 'shoper';
	$dbh      = new PDO($dsn, $user, $password);
	$dbh->query('set names utf8');

	$sql    = 'select name from mst_staff where code = ? and password = ?';
	$stmt   = $dbh->prepare($sql);
	$data[] = $staff_code;
	$data[] = $staff_pass;
	$stmt->execute($data);

	$dbh = null;

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	// 投げたSQLの返りがfalseだった場合
	if($rec == false) {
		print 'スタッフコードかパスワードが間違っています。';
		print '<a href = "staff_login.html">戻る</a>';
	}


	else {
		// 自動で合言葉を決めてもらいます
		session_start();
		// ログインOKという証拠を残します
		$_SESSION['login']  = 1;
		// 今後使えそうなデータを入れとくと便利
		$_SESSION['staff_code'] = $staff_code;
		$_SESSION['staff_name'] = $rec['name'];
		header('Location:staff_top.php');
	}

}

catch(Exception $e) {
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

</body>
</html>
