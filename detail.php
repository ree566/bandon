<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "點菜詳細";
$PAGE = "detail";
$MAIN = get_include_contents("module/detail_main.php");

include "module/layout.php";

