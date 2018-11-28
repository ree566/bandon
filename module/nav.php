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
            <ul class="nav navbar-nav navbar-left">
                <?php if ($_SESSION["permission"] >= 2) { ?>
                    <li>
                        <div class="btn-group navbar-btn">
                            <button class="btn btn-danger">管理</button>
                            <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle"><span
                                        class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="control.php">管理總表</a></li>
                                <li><a href="manage-user.php">管理使用者</a></li>
                                <li><a href="manage-purse.php">餘額異動</a></li>
                                <?php if ($_SESSION["permission"] >= 3) { ?>
                                    <li>
                                        <a href="manage-floor.php">設定樓層</a>
                                    </li>
                                <?php } ?>
                                <li><a href="purse-search.php">交易紀錄</a></li>
<!--                                <li class="divider"></li>-->
<!--                                <li><a href="#">Separated link</a></li>-->
                            </ul>
                        </div>
                    </li>
                <?php } ?>

                <li>
                    <a href="view.php">我的點餐</a>
                </li>
                <li>
                    <a href="purse.php">我的錢包</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="account.php">修改密碼</a>
                </li>
                <li>
                    <a href="logout.php">登出</a>
                </li>
            </ul>
        </div>
    </div>
</nav>