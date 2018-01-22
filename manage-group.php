<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "管理菜單";
$PAGE = "manage-group";
$MAIN = get_include_contents("module/manage-group-main.php");

include "module/layout.php";

