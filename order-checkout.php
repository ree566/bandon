<?php
$PERMISSION = 2;
include "module/session.php";
include "module/locker.php";

require_once "module/dbc.php";

$UID = $_SESSION["uid"];
$TITLE = "order checkout";
$PAGE = "order-checkout";
//$PAGE = "manage-group";
$MAIN = get_include_contents("module/order-checkout-main.php");

include "module/layout.php";

