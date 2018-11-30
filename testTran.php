<?php
/**
 * Created by PhpStorm.
 * User: Wei.Cheng
 * Date: 2018/11/19
 * Time: 上午 10:06
 */

require_once 'module/dbc.php';
require_once "module/operator_func.php";

session_start();

$_SESSION["uid"] = 'BB';
$_SESSION["permission"] = '99';
$_SESSION["floor_id"] = '5';

$PDO = dbc();

$user_id = 'A-7568';
$floor_id = 5;

$re = get_purse_event("A-7568 or test", null);

print_r($re);

