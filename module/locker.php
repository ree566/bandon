<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");

$PDO = dbc();

$floor_id = $_SESSION["floor_id"];
$floor = get_floor($floor_id);

$LOCKER = $floor["open"] == 0;

if(!isset($LOCKER)){
	$LOCKER = true;
}


