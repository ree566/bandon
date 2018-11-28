<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "交易紀錄查詢";
$PAGE = "purse-search";
$MAIN = get_include_contents("module/purse-search-main.php");

include "module/layout.php";

