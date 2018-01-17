<?php
$PERMISSION = 1;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "修改密碼";
$PAGE = "account";
$MAIN = get_include_contents("module/account_main.php");

include "module/layout.php";

