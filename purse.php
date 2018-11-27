<?php
$PERMISSION = 1;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "我的錢包";
$PAGE = "purse";
$MAIN = get_include_contents("module/purse-main.php");

include "module/layout.php";

