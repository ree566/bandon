<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "統計結果";
$PAGE = "control";
$MAIN = get_include_contents("module/control_main.php");

include "module/layout.php";

