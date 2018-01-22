<?php
$PERMISSION = 2;
include("module/session.php");

require_once("module/dbc.php");

$mysqli = dbc();
$floor_id = $_SESSION["floor_id"];
$mysqli->query("UPDATE floors SET open=1 WHERE id = $floor_id");
$mysqli->close();

header("Location: control.php");
?>