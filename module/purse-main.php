<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");

$PDO = dbc();
$user_id = $_SESSION["uid"];
$purse = get_purse($user_id);
$purse_event = get_purse_event($user_id)

?>
<form method="post" class="" role="form">
    <h3>您的餘額: $<?= $purse["amount"] ?></h3>
    <div class="panel panel-default">
        <div class="panel-heading">餘額異動紀錄</div>
        <table class="group table text-left sortable table-striped table-hover">
            <thead>
            <tr>
                <td>id</td>
                <td>項目</td>
                <td>金額</td>
                <td>訂購日期</td>
                <td>異動人員</td>
                <td>異動日期</td>
                <td>備註</td>
            </tr>
            </thead>
            <tbody class="event-list">
            <?php foreach ($purse_event as $event) { ?>
                <tr data-uid="<?= $event["purse_event_id"] ?>" class="purse">
                    <td><?= $event["purse_event_id"] ?></td>
                    <td><?= $event["item_kind"] . "x" . $event["order_number"] ?></td>
                    <td><?= (isset($event["amount"]) ? ($event["amount"] > 0 ? "+" : "") . $event["amount"] : (isset($event["item_kind"]) ? -($event["kind_price"] * $event["order_number"]) : 'n/a')) ?></td>
                    <td><?= isset($event["createDate"]) ? date('Y-m-d', strtotime($event["createDate"])) : 'n/a' ?></td>
                    <td><?= $event["mod_user_name"] ?></td>
                    <td><?= date('Y-m-d', strtotime($event["mod_date"])) ?></td>
                    <td><?= isset($event["remark"]) ? $event["remark"] : "n/a" ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    </p>
    <div class="btn-group">
        <a href="view.php" class="btn btn-default">返回</a>
    </div>

</form>