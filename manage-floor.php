<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "設定樓層";
$PAGE = "manage-floor";
$MAIN = get_include_contents("module/manage-floor-main.php");

include "module/layout.php";

