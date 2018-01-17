<!DOCTYPE html>
<html class="<?=$PAGE?>" lang="tw">

<head>
	<meta charset="utf-8" />
	<title>便當訂購</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<script src="common.min.js"></script>
	<script src="<?=$PAGE?>.min.js"></script>
	<link rel="stylesheet" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="sorttable.min.js"></script>

	<!--[if lt IE 9]>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
	<script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>


<?php include "module/nav.php"?>

<div class="container-fluid">

	<?php include("module/header.php") ?>
	
	<div class="main text-center center-block">
		<?=$MAIN?>
	</div>
	<div class="clearfix"></div>
	<footer class="text-right">
		&copy; 2014 Advantech.com.tw<br>
	</footer>
</div>

</body>
</html>