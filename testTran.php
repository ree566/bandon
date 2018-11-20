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

$row = get_user('root', false, false);


echo print_r($row);
