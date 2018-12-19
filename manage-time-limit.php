<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "設定店家時限";
$PAGE = "manage-time-limit";

$MAIN = get_include_contents("module/manage-time-limit-main.php");

include "module/layout.php";

