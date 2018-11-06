<?php
session_start();

if((!isset($_SESSION["uid"]) || $_SESSION["permission"] < $PERMISSION) && $PAGE != "login"){
	header("Location: logout.php");
	die;
}

