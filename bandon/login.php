<?php
session_start();

if(isset($_POST["uid"], $_POST["pwd"])){
	require_once "module/dbc.php";
	$mysqli = dbc();
	
	$uid = $mysqli->escape_string($_POST["uid"]);
	$pwd = $mysqli->escape_string($_POST["pwd"]);
	$pass_hash = pw_hash($pwd);
	$re = $mysqli->query("SELECT * FROM users WHERE id = '$uid' && pass_hash = '$pass_hash'");
	if($re && $row = $re->fetch_assoc()){
		// Login success
		$_SESSION["uid"] = $uid;
		$_SESSION["name"] = $row["name"];
		$_SESSION["permission"] = (int)$row["permission"];
		$_SESSION["floor_id"] = (int)$row["floor_id"];
		
		// $re = $mysqli->query("SELECT * FROM orders WHERE user_id = '$uid'");

		header("Location: view.php");
		die;
	}else{
		$LOGIN_FAILED = true;
	}
}

if(isset($_SESSION["uid"])){
	header("Location: view.php");
	die;
}

?>
<!DOCTYPE html>
<html class="login">

<head>
	<meta charset="utf-8">
	<title>便當訂購</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="common.min.js"></script>
	<link rel="stylesheet" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div class="container-fluid">

	<h1>登入</h1>
	
	<div class="row main center-block">
		<form method="post" role="form">
			<div class="form-group">
				<label for="account">帳號︰</label>
				<input type="text" class="form-control" placeholder="輸入工號" name="uid">
			</div>
			<div class="form-group">
				<label for="pass">密碼︰</label>
				<input type="password" class="form-control" placeholder="輸入密碼" name="pwd">
			</div>
			<div class="form-group text-danger status-info">
			<?php if (isset($LOGIN_FAILED) && $LOGIN_FAILED) { ?>
				登入失敗！
			<?php } ?>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default">登入</button>
				<small class="btn-text"><a href="document.html">使用手冊</a></small>
			</div>
		</form>
	</div>
	
	<footer class="text-right">
		&copy; 2014 Advantech.com.tw<br>
	</footer>
</div>

</body>
</html>