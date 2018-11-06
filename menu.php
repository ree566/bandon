<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "編輯菜單";
$PAGE = "menu";
$MAIN = get_include_contents("module/menu_main.php");

include "module/layout.php";
