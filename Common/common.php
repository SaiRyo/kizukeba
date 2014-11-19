<?php

function gengo($seireki) {
	if(1868 <= $seireki && $seireki <= 1911) {
		$gengo = '明治';
	}

	else if(1912 <= $seireki && $seireki <= 1925) {
		$gengo = '大正';
	}

	else if(1926 <= $seireki && $seireki <= 1988) {
		$gengo = '昭和';
	}

	else if(1989 <= $seireki) {
		$gengo = '平成';
	}

	else {
		print '1868以上の年を入力してください';
	}

	return ($gengo);

}

function sanitize($brefore) {
	foreach($before as $key => $value) {
		$after[$key] = htmlspecialchars($value);
	}

	return $after;
}
?>