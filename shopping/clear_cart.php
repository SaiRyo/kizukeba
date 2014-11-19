<?php

// セッション変数(秘密文書)を空にする
$_SESSION = array();

// セッションIDが存在する場合
if(isset($_COOKIE[session_name()]) == true) {
	// パソコン側のセッションID(合言葉)をクッキーから削除する。
	setcookie(session_name(), '', time() - 42000, '/');
}

// セッションを破棄する(サーバーとあなたのパソコンの関係を断ち切る)
@session_destroy();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>ろくまる農園</title>
</head>
<body>

カートを空にしました。<br />

</body>
</html>