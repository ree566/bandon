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

$data = array(5,115,123,127,157,159,201,222,223,235,306,315);
$data2 = array(5);
$data3 = array('id' => "'5', '115', '123', '127', '157', '159', '201', '222', '223', '235', '306', '315'");
$data4 = array('5', '115', '123', '127', '157', '159', '201', '222', '223', '235', '306', '315');
$data5 = array('5');
$json = get_checkout_orders($_SESSION["floor_id"], $data);
//$json2 = get_checkout_orders($_SESSION["floor_id"], $data2);

print_r($json);
print_r('------------------');
//print_r($json2);

