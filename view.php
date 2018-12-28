<?php
$PERMISSION = 1;
include "module/session.php";
include "module/locker.php";

require_once("module/dbc.php");

$UID = $_SESSION["uid"];
$TITLE = "點餐系統";
$PAGE = "view";
$MAIN = get_include_contents("module/view_main.php");

$url1=$_SERVER['REQUEST_URI'];
header("Refresh: 600; URL=$url1");

include "module/layout.php";

