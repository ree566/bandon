<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");
include "module/locker.php";

$PDO = dbc();
$floor_id = $_SESSION["floor_id"];
$orders = get_checkout_orders($floor_id, $_REQUEST["groups"]);

?>
<?php
if (!isset($_REQUEST["groups"])) {
    header('Location: view.php');
}
if (isset($_COOKIE["paid_temp"])) {
    $info = $_COOKIE["paid_temp"];
    $info = json_decode($info, true);
}
?>
<?php if ($LOCKER == false) { ?>
    <div class='alert alert-danger'>請結束訂購後再進行資料結算</div>
    <div class="btn-group">
        <a href="control.php" class="btn btn-default">返回</a>
    </div>
<?php } else { ?>

    <?php if (empty($orders)) { ?>
        <h3>無可結算資料</h3>
        <a href="control.php" class="btn btn-default">返回</a>
    <?php } else { ?>
        <h5>
            <ur style="color: red">
                <li>金額留空 = 付全額</li>
                <li>金額為0 = 未付錢</li>
                <li>備註為選填</li>
            </ur>
        </h5>
        <form method="post" class="" role="form">
            <table class="table table-hover">
                <thead>
                <tr>
                    <td data-visible="false">order_id</td>
                    <td data-visible="false">purse_id</td>
                    <td data-visible="false">user_id</td>
                    <td>user_name</td>
                    <td>createDate</td>
                    <td>應付金額</td>
                    <td>實付金額</td>
                    <td>餘額</td>
                    <td>備註</td>
                </tr>
                </thead>
                <tbody class="order-list">
                <?php foreach ($orders as $order) { ?>
                    <tr data-uid="<?= $order["order_id"] ?>" class="order">
                        <td class="order_id"><?= $order["order_id"] ?></td>
                        <td class="purse_id"><?= $order["purse_id"] ?></td>
                        <td class="user_id"><?= $order["user_id"] ?></td>
                        <td class="user_name"><?= $order["user_name"] ?></td>
                        <td class="createDate"><?= $order["createDate"] ?></td>
                        <td class="totalPrice"><?= $order["totalPrice"] ?></td>
                        <td class="paid"><input type="number" class="order-paid form-control" placeholder="輸入已付金額"
                                                min="0"
                                                max="2000"
                                                value="<?= isset($info['P' . $order["purse_id"]]) ? $info['P' . $order["purse_id"]] : 0 ?>"/>
                        </td>
                        <td class="balance">
                            <input class="origin-balance" type="hidden" value="<?= $order["balance"] ?>">
                            <div class="balance-calc">
                                <?= isset($info['P' . $order["purse_id"]]) ? $order["balance"] - $order["totalPrice"] + $info['P' . $order["purse_id"]] : $order["balance"] ?>
                            </div>
                        </td>
                        <td class="remark"><input type="text" class="order-remark form-control" placeholder="輸入備註"/>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            </p>
            <div class="btn-group">
                <a href="control.php" class="btn btn-default">返回</a>
                <button class="btn btn-default submit" type="button">儲存</button>
                <button class="btn btn-default reset" type="button">Reset</button>
                <h5 style="color: red">※請務必再三確認完成再送出</h5>
            </div>
        </form>
    <?php } ?>
<?php } ?>