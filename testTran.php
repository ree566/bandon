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

$MYSQLI = dbc();
//$sqlStr = [
//    "Update `floors` set `open` = $sign where id = 1",
//    "Update `floosrs` set `open` = $sign where id = 2",
//    "Update `floors` set `open` = $sign where id = 3"
//];
//$re = Q2(...$sqlStr);

$re = Q2(
    "Update `floors` set `open` = $sign where id = 1",
    "Update `floors` set `open` = $sign where id = 2",
    "Update `floors` set `open` = $sign where id = 3"
);


echo print_r($re);
