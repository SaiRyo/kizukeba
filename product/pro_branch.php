<?php
// ログインチェック
include("../Common/CommonMethod.php");

CommonMethod::loginCheckSec();

	if(isset($_POST['edit']) == true) {

		//if(isset($_POST['procode']) == false) {
		if(isset($_POST['procode']) == false) {
			header('Location:pro_ng.php');
			return;
		}

/*
		if(empty($_POST['procode']) === true) {
			header('Location:pro_ng.php');
			return;
		}		
*/

		$pro_code = $_POST['procode'];
		header('Location:pro_edit.php?procode=' . $pro_code);
		//header('Location:pro_edit.php?procode=5');

		return;
	}

	else if(isset($_POST['delete']) == true) {

		if(isset($_POST['procode']) == false) {
			header('Location:pro_ng.php');
			return;
		}

		$pro_code = $_POST['procode'];
		header('Location:pro_delete.php?procode=' . $pro_code);

		return;
	}

	else if(isset($_POST['add']) == true) {
		header('Location:pro_add.php');
		return;
	}

	else if(isset($_POST['disp']) == true) {

		if(isset($_POST['procode']) == false) {
			header('Location:pro_ng.php');
			return;
		}

		$pro_code = $_POST['procode'];
		header('Location:pro_disp.php?procode=' . $pro_code);

		return;
	}	

?>
