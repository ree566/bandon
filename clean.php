<?php
$PERMISSION = 2;
include "module/session.php";

require_once "module/dbc.php";

$mysqli = dbc();
$floor_id = $_SESSION["floor_id"];
$mysqli->query("DELETE FROM orders WHERE floor_id=$floor_id");

header("Location: control.php");
?>