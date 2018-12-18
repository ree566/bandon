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

$json = '{"orders":[{"floor":{"id":"5","name":"五樓","open":1},"item":{"id":"564","name":"泡菜牛肉"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休"},"kind":{"id":"713","name":"拉麵","price":"85"},"options":[],"number":13},{"floor":{"id":"5","name":"五樓","open":1},"item":{"id":"725","name":"原味牛肉"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休"},"kind":{"id":"913","name":"拉麵","price":"85"},"options":[],"number":3},{"floor":{"id":"5","name":"五樓","open":1},"item":{"id":"724","name":"原味豬肉"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休"},"kind":{"id":"901","name":"拉麵","price":"85"},"options":[],"number":3},{"floor":{"id":"5","name":"五樓","open":1},"item":{"id":"27","name":"沙茶豬肉"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休"},"kind":{"id":"37","name":"拉麵","price":"85"},"options":[],"number":5},{"floor":{"id":"5","name":"五樓","open":1},"item":{"id":"26","name":"泡菜豬肉"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休"},"kind":{"id":"34","name":"拉麵","price":"85"},"options":[],"number":4}]}';
$json = json_decode($json, true);

$re = set_orders($json);


print_r($re);

