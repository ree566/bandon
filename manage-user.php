<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "使用者管理";
$PAGE = "manage-user";
$MAIN = get_include_contents("module/manage-user-main.php");

include "module/layout.php";

