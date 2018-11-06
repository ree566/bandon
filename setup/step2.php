<?php
// step2. close setup.

require_once("../module/dbc.php");

if(isset($_POST["submit"])){
	$deny = "deny from all";
	file_put_contents(".htaccess", $deny);
	header("Location: ../logout.php");
	die;
}
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
	<h1>設定完成</h1>
	<p>按下確認即可關閉 setup 並導向登入頁面。</p>
	<form role="form" method="POST">
		<button type="submit" class="btn btn-default" name="submit">確認</button>
	</form>
</div>

</body>
</html>