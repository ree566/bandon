<?php
// index. check database information, create table then write to dbAccount.

@$db_host = $_POST["db-server"];
@$db_name = $_POST["db-name"];
@$db_user = $_POST["db-user"];
@$db_pass = $_POST["db-pass"];

@$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!$db_host || !$db_name || !$db_user || !$db_pass){
		$error_message = "請勿留空。";
	}else if($mysqli->connect_errno){
		$error_message = "與資料庫連線失敗，請檢查是否輸入錯誤。<br>{$mysqli->connect_error}";
	}else{
		$sql = file_get_contents("bandon.sql");
		$mysqli->set_charset("utf8");
		if($mysqli->multi_query($sql)){
			while($mysqli->next_result()){;}
			if($mysqli->errno){
				$error_message = "建立資料失敗。<br>{$mysqli->error}";
			}else{
				$ehost = addslashes($db_host);
				$ename = addslashes($db_name);
				$euser = addslashes($db_user);
				$epass = addslashes($db_pass);
				
				$text = <<<EOF
<?php
\$DB_SERV = '$ehost';
\$DB_NAME = '$ename';
\$DB_USER = '$euser';
\$DB_PASS = '$epass';

EOF;
				
				file_put_contents("../module/dbAccount.php", $text);
				
				header("Location: step1.php");
				die;
			}
		}else{
			$error_message = "建立資料失敗。<br>{$mysqli->error}";
		}
	}
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
	<h1>設定資料庫資訊</h1>
<?php if(isset($error_message)){ ?>
	<p class="alert alert-danger"><?=$error_message?></p>
<?php } ?>
	<form role="form" method="post">
		<p>輸入以下資料庫資訊後繼續</p>
		<div class="form-group">
			<label for="db-server">伺服器位址</label>
			<input type="text" class="form-control" id="db-server" name="db-server" placeholder="若是在本機請輸入 localhost" value="<?=$db_host?>" />
		</div>
		<div class="form-group">
			<label for="db-name">資料庫名稱</label>
			<input type="text" class="form-control" id="db-name" name="db-name" placeholder="輸入資料庫名稱" value="<?=$db_name?>" />
		</div>
		<div class="form-group">
			<label for="db-user">使用者名稱</label>
			<input type="text" class="form-control" id="db-user" name="db-user" placeholder="輸入使用者名稱" value="<?=$db_user?>" />
		</div>
		<div class="form-group">
			<label for="db-pass">密碼</label>
			<input type="password" class="form-control" id="db-pass" name="db-pass" placeholder="輸入密碼" />
		</div>
		<button type="submit" class="btn btn-default">送出</button>
	</form>
</div>

</body>
</html>