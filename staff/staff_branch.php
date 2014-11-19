<?php
// ログインチェック
include("../Common/CommonMethod.php");
CommonMethod::loginCheckSec();

	if(isset($_POST['edit']) == true) {

		//if(isset($_POST['staffcode']) == false) {
		if(isset($_POST['staffcode']) == false) {
			header('Location:staff_ng.php');
			return;
		}

/*
		if(empty($_POST['staffcode']) === true) {
			header('Location:staff_ng.php');
			return;
		}		
*/

		$staff_code = $_POST['staffcode'];
		header('Location:staff_edit.php?staffcode=' . $staff_code);
		//header('Location:staff_edit.php?staffcode=5');

		return;
	}

	else if(isset($_POST['delete']) == true) {

		if(isset($_POST['staffcode']) == false) {
			header('Location:staff_ng.php');
			return;
		}

		$staff_code = $_POST['staffcode'];
		header('Location:staff_delete.php?staffcode=' . $staff_code);

		return;
	}

	else if(isset($_POST['add']) == true) {
		header('Location:staff_add.php');
		return;
	}

	else if(isset($_POST['disp']) == true) {

		if(isset($_POST['staffcode']) == false) {
			header('Location:staff_ng.php');
			return;
		}

		$staff_code = $_POST['staffcode'];
		header('Location:staff_disp.php?staffcode=' . $staff_code);

		return;
	}	

?>
