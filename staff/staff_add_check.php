<?php

	include("../Common/CommonMethod.php");

	CommonMethod::loginCheck();

	// postで送られてきた情報をサニタイジング
	$post = CommonMethod::sanitize($_POST);

	//前の画面から入力データを受け取って変数に入れていく
	$staff_name  = $post['name'];
	$staff_pass  = $post['pass'];
	$staff_pass2 = $post['pass2']; 

	//もしスタッフ名が入力されていなかったら
	if($staff_name == ''){
		//「スタッフ名が入力されていません」と表示
		print 'スタッフ名が入力されていません。<br />';
	}
	// もしスタッフ名が入力されてたら
	else{
		print 'スタッフ名：';
		print $staff_name;
		print '<br />';
	}
	//もしパスワードが入力されていなかったら
	if($staff_pass == ''){
		print 'パスワードが入力されていません。<br />';
	}

	//もし、パスワードと確認のためにもう一度入力してもらったパスワードが同じでなかったら
	if($staff_pass != $staff_pass2){
		print 'パスワードが一致しません。<br />';
	}

	// もし、入力に問題があったら「戻る」ボタンだけを表示
	if($staff_name == "||$staff_pass=="||$staff_pass!=$staff_pass2){
		print '<form>';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '< /form>';
	}
	// もし、入力に問題がなかったら、「戻る」ボタンと「OK」ボタンの両方を表示
	else{
		// パスワードをMD5という暗号規格に従って暗号化
		$staff_pass = md5($staff_pass);
		print '<form method="post" action="staff_add_done.php">';
		print '<input type="hidden" name="name" value="'.$staff_name.'">';
		print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
		print '<br />';
		print '<input type="button" onclick="histry.back()" value="戻る">';
		print '<input type="submit" value="OK">';
		print '</form>';
	}

//疑問点
//histry.back()とは
//htmlspecialcharactersとは
//input type="hidden"とは

?>

<body>



</body>