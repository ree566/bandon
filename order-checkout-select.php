<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "選擇訂購結算";
$PAGE = "order-checkout-select";

$MAIN = get_include_contents("module/order-checkout-select-main.php");

include "module/layout.php";

