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

$user_id = 'root';

//update("delete o from orders o where o.user_id = '$user_id'");
batchUpdate("insert into orders(user_id) values('$user_id') ", "insert into orders(user_id) values('$user_id') ");

$id = last_id();


echo print_r($id);
