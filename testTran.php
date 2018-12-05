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

$json = '{"orders":[{"id":"51931","user_id":"root","createDate":"2018-11-30 15:59:46","option_ids":"","kind_id":"713","number":0,"floor_id":"5","item_id":"564","item":{"id":"564","name":"泡菜牛肉","group_id":"5"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休","hidden":"0","tel":"0922-460-908"},"kind":{"id":"713","name":"拉麵","price":85,"item_id":"564"},"floor":{"id":"5","name":"五樓","open":"1"},"user":{"id":"root","pass_hash":"f32d8ce23c88f57867aefc56fb81fe56","permission":"999","name":"Administrator","user_group":"", "user_name":"Administrator","user_group":"1","floor_id":"5","floor":{"id":"5","name":"五樓","open":"1"}},"options":[]},{"floor":{"id":"5","name":"五樓","open":1},"item":{"id":"725","name":"原味牛肉"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休"},"kind":{"id":"713","name":"拉麵","price":"85"},"options":[],"number":1},{"floor":{"id":"5","name":"五樓","open":1},"item":{"id":"724","name":"原味豬肉"},"group":{"id":"5","name":"9/11漲價>鍋燒麵 0960-638-948周一公休"},"kind":{"id":"37","name":"拉麵","price":"85"},"options":[],"number":1}]}';
//$json = json_decode($json, true);
//print_r($json);
//
//$re = set_orders($json);


print_r($re);

