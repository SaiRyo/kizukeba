<?php

class CommonMethod {

	function loginCheck() {

		// 合言葉を確認する
		session_start();
		// 自分のパソコンとサーバーだけの間で毎回合言葉を変更
		// セッションIDが盗まれないようにする(セッションハイジャック対策のため)
		session_regenerate_id(true);

		// もしログインOKのの証拠がかい場合
		if(isset($_SESSION['login']) == false) {

			print 'ログインされていません。<br />';
			print '<a href = "../staff_login/staff_login.html">ログイン画面へ</a>';
			// exitで強制終了して、これ以降の画面は見せない
			exit();
		}
		else {
			print $_SESSION['staff_name'];
			print 'さんログイン中<br />';
			print '<br />';
		}

	}

	function loginCheckSec() {

		// 合言葉を確認する
		session_start();
		// 自分のパソコンとサーバーだけの間で毎回合言葉を変更
		// セッションIDが盗まれないようにする(セッションハイジャック対策のため)
		session_regenerate_id(true);

		// もしログインOKのの証拠がかい場合
		if(isset($_SESSION['login']) == false) {

			print 'ログインされていません。<br />';
			print '<a href = "../staff_login/staff_login.html">ログイン画面へ</a>';
			// exitで強制終了して、これ以降の画面は見せない
			exit();
		}

	}

	function loginCheckShop() {

		// 合言葉を確認する
		session_start();
		// 自分のパソコンとサーバーだけの間で毎回合言葉を変更
		// セッションIDが盗まれないようにする(セッションハイジャック対策のため)
		session_regenerate_id(true);

		// もしログインOKのの証拠がかい場合
		if(isset($_SESSION['member_login']) == false) {

			print 'ようこそゲスト様　';
			print '<a href = "member_login.html">会員ログイン</a><br />';
			print '<br />';
		}
		else {
			print 'ようこそ　';
			print $_SESSION['member_name'];
			print '様　';
			print '<a href="member_logout.php">ログアウト</a><br />';
			print '<br />';
		}

	}

	function loginCheckMem() {

		// 合言葉を確認する
		session_start();
		// 自分のパソコンとサーバーだけの間で毎回合言葉を変更
		// セッションIDが盗まれないようにする(セッションハイジャック対策のため)
		session_regenerate_id(true);

		// もしログインOKのの証拠がかい場合
		if(isset($_SESSION['member_login']) == false) {

			print 'ログインされていません。<br />';
			print '<a href = "shop_list.php">商品一覧へ</a>';
			// exitで強制終了して、これ以降の画面は見せない
			exit();
		}

	}

	// postで渡ってきた情報をサニタイジング
	function sanitize($before) {
		foreach($before as $key => $value) {
			$after[$key] = htmlspecialchars($value);
		}

		return $after;
	}	

	function pulldown_year() {

		print '<select name="year">';
		print '<option value="2013">2013</option>';
		print '<option value="2014">2014</option>';
		print '<option value="2015">2015</option>';
		print '<option value="2016">2016</option>';
		print '</select>';
	}

	function pulldown_month() {
		print '<select name="month">';
			print '<option value="01">01</option>';
			print '<option value="02">02</option>';
			print '<option value="03">03</option>';
			print '<option value="04">04</option>';
			print '<option value="05">05</option>';
			print '<option value="06">06</option>';
			print '<option value="07">07</option>';
			print '<option value="08">08</option>';
			print '<option value="09">09</option>';
			print '<option value="10">10</option>';
			print '<option value="11">11</option>';
			print '<option value="12">12</option>';
		print '</select>';
	}

	function pulldown_day() {	
		print '<select name="day">';
			print '<option value="01">01</option>';
			print '<option value="02">02</option>';
			print '<option value="03">03</option>';
			print '<option value="04">04</option>';
			print '<option value="05">05</option>';
			print '<option value="06">06</option>';
			print '<option value="07">07</option>';
			print '<option value="08">08</option>';
			print '<option value="09">09</option>';
			print '<option value="10">10</option>';
			print '<option value="11">11</option>';
			print '<option value="12">12</option>';
			print '<option value="13">13</option>';
			print '<option value="14">14</option>';
			print '<option value="15">15</option>';
			print '<option value="16">16</option>';
			print '<option value="17">17</option>';
			print '<option value="18">18</option>';
			print '<option value="19">19</option>';
			print '<option value="20">20</option>';
			print '<option value="21">21</option>';
			print '<option value="22">22</option>';
			print '<option value="23">23</option>';
			print '<option value="24">24</option>';
			print '<option value="25">25</option>';
			print '<option value="26">26</option>';
			print '<option value="27">27</option>';
			print '<option value="28">28</option>';
			print '<option value="29">29</option>';
			print '<option value="30">30</option>';
			print '<option value="31">31</option>';
		print '</select>';

	}

	// テスト関数
	function outputTest() {
		print_r($_SESSION);
	}

}
?>
