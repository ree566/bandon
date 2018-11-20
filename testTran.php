<?php
/**
 * Created by PhpStorm.
 * User: Wei.Cheng
 * Date: 2018/11/19
 * Time: 上午 10:06
 */

require_once 'module/dbc.php';
require_once "module/operator_func.php";

$sign = 0;

$PDO = dbc();

$sql = [
    "update floors set open = $sign where id = 1",
    "update floors set open = $sign where id = 2",
    "update floors set open = $sign where id = 3"
];

$re = batchUpdate(
    ...$sql
);


echo print_r($re);
