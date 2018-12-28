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

$_SESSION["uid"] = 'root';
$_SESSION["permission"] = '99';
$_SESSION["floor_id"] = '5';

$PDO = dbc();

$json = array(
    "orders" => array(
        array(
            "paid" => "0",
            "user_id" => "root",
            "purse_id" => "173",
            "order_id" => "52020",
            "totalPrice" => "170"
        )
    ),
    "groups_checkout" => "5, 7"
);
set_checkout_orders($json);
//$json2 = get_checkout_orders($_SESSION["floor_id"], $data2);

//print_r($json);
//print_r('------------------');
//print_r($json2);

