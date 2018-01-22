<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "匯入菜單";
$PAGE = "select-group";
$MAIN = get_include_contents("module/select-group-main.php");

include "module/layout.php";

