<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "餘額異動";
$PAGE = "manage-purse";
$MAIN = get_include_contents("module/manage-purse-main.php");

include "module/layout.php";

