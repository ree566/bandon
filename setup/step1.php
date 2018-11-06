<?php
// step1. get root pass then set root pass.

require_once("../module/dbc.php");

$mysqli = dbc();
$success = "成功連線！<br>$mysqli->host_info<br>MySQL $mysqli->server_info";

if(isset($_POST["pass"])){
	$hash = pw_hash($_POST["pass"]);
	$mysqli->query("UPDATE users SET pass_hash='$hash' WHERE id = 'root'");
	header("Location: step2.php");
	die;
}

$mysqli->close();

?><!DOCTYPE html>
<html lang="tw">

<head>
	<meta charset="utf-8" />
	<title>INSTALL</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" />

	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>

<div class="container">
	<h1>設定 root 密碼</h1>
	<form role="form" method="post">
		<p class="alert alert-success"><?=$success?></p>
		<p>輸入總管理員密碼後繼續</p>
		<div class="form-group">
			<label>總管理員帳號</label>
			<p class="form-control-static">root</p>
		</div>
		<div class="form-group">
			<label for="pass">密碼</label>
			<input type="password" class="form-control" id="pass" name="pass" placeholde="輸入資料庫名稱" />
		</div>
		<button type="submit" class="btn btn-default">送出</button>
	</form>
</div>

</body>
</html>