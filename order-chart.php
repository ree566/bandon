<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "訂購次數總表";
$PAGE = "order-chart";
$MAIN = get_include_contents("module/order-chart-main.php");

include "module/layout.php";


