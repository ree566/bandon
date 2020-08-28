<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");

$PDO = dbc();
$user_id = $_SESSION["uid"];
$purse = get_purse($user_id);
$purse_event = get_purse_event($user_id);

?>
<link rel="stylesheet" href="lib/bootstrap-table/bootstrap-table.min.css">
<script src="lib/bootstrap-table/bootstrap-table.min.js"></script>
<style>
    .center-block {
        display: table;
        margin: 0 auto;
    }
</style>
<form method="post" class="" role="form">
    <div class="row">
        <div class="col-md-12">
            <div class="center-block text-center">
                <h3>您的餘額: $<?= $purse["amount"] ?></h3>
                <div class="panel panel-default">
                    <div class="panel-heading">餘額異動紀錄<b style="color: red">(※僅顯示1周內)</b></div>
                    <table id="purse-event" class="group table text-left sortable table-striped table-hover">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>項目</th>
                            <th>金額</th>
                            <th>訂購日期</th>
                            <th>異動人員</th>
                            <th>異動日期</th>
                            <th>異動前餘額</th>
                            <th>備註</th>
                        </tr>
                        </thead>
                        <tbody class="event-list">
                        <?php foreach ($purse_event as $event) { ?>
                            <tr data-uid="<?= $event["purse_event_id"] ?>" class="purse">
                                <td><?= $event["purse_event_id"] ?></td>
                                <td><?= $event["item_kind"] . "x" . $event["order_number"] ?></td>
                                <td><?= isset($event["kind_price"]) ? -($event["kind_price"] * $event["order_number"]) : (($event["amount"] > 0 ? "+" : "") . $event["amount"]) ?>
                                    元
                                </td>
                                <td><?= isset($event["createDate"]) ? date('Y-m-d', strtotime($event["createDate"])) : 'n/a' ?></td>
                                <td><?= $event["mod_user_name"] ?></td>
                                <td><?= date('Y-m-d', strtotime($event["mod_date"])) ?></td>
                                <td><?= $event["purse_amount_temp"] ?>元</td>
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
            </div>
        </div>
    </div>
</form>