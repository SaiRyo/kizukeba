<?php
include("../Common/CommonMethod.php");
CommonMethod::loginCheck();

?>


<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>ろくまる農園</title>
</head>
<body>

ダウンロードしたい注文日を選んでください。<br />
<form method="post" action="order_download_done.php">
<?php
CommonMethod::pulldown_year(); 
?>
年
<?php
CommonMethod::pulldown_month(); 
?>
月
<?php
CommonMethod::pulldown_day(); 
?>

日<br />
<br />
<input type="submit" value="ダウンロード">
</form>

</body>
</html>