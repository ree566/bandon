﻿<?php
$PERMISSION = 2;
include("module/session.php");

require_once("module/dbc.php");
require_once("module/operator_func.php");

$PDO = dbc();
$floor_id = $_SESSION["floor_id"];
start_order($floor_id);

header("Location: control.php");
