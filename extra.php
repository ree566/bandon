<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "編輯細項";
$PAGE = "extra";
$MAIN = get_include_contents("module/extra_main.php");

include "module/layout.php";
