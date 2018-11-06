<nav class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="navbar-brand">
				歡迎！<?php echo($_SESSION["name"]) ?>
			</div>
		</div>
		<div class="navbar-collapse collapse text-right" id="nav-collapse">
			<span class="navbar-left">
			<?php if($_SESSION["permission"] >= 2){ ?>
				<a href="control.php" class="btn btn-default navbar-btn">管理</a>
			<?php } if ($_SESSION["permission"] >= 3) {?>
				<a href="manage-floor.php" class="btn btn-default">設定樓層</a>
			<?php } ?>
				<a href="view.php" class="btn btn-default navbar-btn">我的點餐</a>
			</span>
			<span class="navbar-right">
				<a href="account.php" class="btn btn-default navbar-btn">修改密碼</a>
				<a href="logout.php" class="btn btn-default navbar-btn">登出</a>
			</span>
		</div>
	</div>
</nav>