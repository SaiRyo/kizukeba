<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>ろくまる農園</title>
</head>
<body>

</body>
</html>

<?php

/*
int $seireki = 0;
string $wareki = '';
*/

require_once('../common/common.php');

$seireki = $_POST['seireki'];

$wareki = gengo($seireki);
print $wareki;



?>