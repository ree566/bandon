<?php
require_once("module/dbc.php");

$mysqli = dbc();
$floor_id = $_SESSION["floor_id"];
if($re = $mysqli->query("SELECT * FROM floors WHERE id = $floor_id && open = 1")){
	if($re->num_rows){
		$LOCKER = false;
	}
	$re->close();
}

if(!isset($LOCKER)){
	$LOCKER = true;
}

$mysqli->close();

